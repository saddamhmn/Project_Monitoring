<?php

namespace App\Http\Controllers;

use App\Models\Building;
use App\Models\BuildingFloor;
use App\Models\Cctv;
use App\Models\CctvMaintenanceLog;
use App\Models\CctvErrorLog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BuildingMaintenanceController extends Controller
{
    public function show(Building $building)
{
    $building->load([
        'floors' => fn($q) => $q->orderBy('floor_number'),
        // Eager load log terbaru untuk semua CCTV sekaligus
        'floors.cctvs.latestMaintenanceLog',
        'floors.cctvs.latestErrorLog',
    ]);

    $floors = $building->floors->map(function ($floor) {
        return [
            'id'          => $floor->id,
            'floor_number'=> $floor->floor_number,
            'floor_name'  => $floor->floor_name,
            'plan_url'    => $floor->plan_path ? Storage::url($floor->plan_path) : null,
            'cctvs'       => $floor->cctvs->map(fn($cctv) => $this->transformCctv($cctv))->values(),
        ];
    })->values();

    return view('buildings.maintenance', [
        'building'      => $building,
        'floorsPayload' => $floors,
    ]);
}

    public function storeCctv(Request $request, BuildingFloor $floor)
    {
        $validated = $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'ip_address'  => ['nullable', 'string', 'max:45'],
            'cctv_type'   => ['required', 'in:dome,bullet,ptz'],
            'description' => ['nullable', 'string'],
            'x_norm'      => ['required', 'numeric', 'min:0', 'max:1'],
            'y_norm'      => ['required', 'numeric', 'min:0', 'max:1'],
        ]);

        $cctv = Cctv::create([
            'building_id'       => $floor->building_id,
            'building_floor_id' => $floor->id,
            'name'              => $validated['name'],
            'ip_address'        => $validated['ip_address'] ?? null,
            'cctv_type'         => $validated['cctv_type'],
            'description'       => $validated['description'] ?? null,
            'x_norm'            => $validated['x_norm'],
            'y_norm'            => $validated['y_norm'],
            'is_error'          => false,
            'last_maintenance_at' => now(),
        ]);

        $cctv->load('maintainedBy');

        return response()->json([
            'message' => 'CCTV ditambahkan.',
            'cctv'    => $this->transformCctv($cctv),
        ]);
    }

    public function destroyCctv(Cctv $cctv)
    {
        $cctv->delete();

        return response()->json([
            'message' => 'CCTV dihapus.',
        ]);
    }

    public function updateCctvInfo(Request $request, Cctv $cctv)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        $cctv->update($validated);
        $cctv->load('maintainedBy');

        return response()->json([
            'message' => 'Informasi CCTV diperbarui.',
            'cctv' => $this->transformCctv($cctv),
        ]);
    }

    public function markMaintenance(Request $request, Cctv $cctv)
    {
        $validated = $request->validate([
            'technician_name' => ['required', 'string', 'max:255'],
            'note' => ['nullable', 'string'],
        ]);

   
        $cctv->update([
    'is_error'                       => false,
    'last_maintenance_at'            => now(),
    'error_acknowledged_at'          => null, 
    'error_acknowledged_by_user_id'  => null,
]);

        $photoPath = $request->hasFile('photo')
        ? $request->file('photo')->store('cctv/maintenance', 'public')
        : null;

        $log=CctvMaintenanceLog::create([
            'cctv_id'        => $cctv->id,
            'user_id'        => auth()->id(),
            'technician_name'=> $request->technician_name,
            'note'           => $request->note,
            'performed_at'   => now(),
            'photo'          => $photoPath,
        ]);

            $cctv->refresh();

            return response()->json([
                'cctv' => $this->transformCctv($cctv->fresh()),
            ]);
        }

    public function markError(Request $request, Cctv $cctv)
    {
        $validated = $request->validate([
            'technician_name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
        ]);

       $cctv->update([
    'is_error'                       => true,
    'last_maintenance_at'            => now(),
    'error_acknowledged_at'          => null,
    'error_acknowledged_by_user_id'  => null,
]);

        $photoPath = $request->hasFile('photo')
        ? $request->file('photo')->store('cctv/errors', 'public')
        : null;

        CctvErrorLog::create([
            'cctv_id'        => $cctv->id,
            'user_id'        => auth()->id(),
            'technician_name'=> $request->technician_name,
            'description'    => $request->description,
            'reported_at'    => now(),
            'photo'          => $photoPath,
        ]);

        return response()->json([
            'cctv' => $this->transformCctv($cctv->fresh()),
        ]);
    }

    private function transformCctv(Cctv $cctv): array
{
    $lastMaintenance = $cctv->relationLoaded('latestMaintenanceLog')
        ? $cctv->latestMaintenanceLog
        : $cctv->maintenanceLogs()->latest('performed_at')->first();

    $lastError = $cctv->relationLoaded('latestErrorLog')
        ? $cctv->latestErrorLog
        : $cctv->errorLogs()->latest('reported_at')->first();

    return [
        'id'                            => $cctv->id,
        'name'                          => $cctv->name,
        'ip_address'                    => $cctv->ip_address,
        'cctv_type'                     => $cctv->cctv_type ?? 'dome',
        'description'                   => $cctv->description,
        'x_norm'                        => (float) $cctv->x_norm,
        'y_norm'                        => (float) $cctv->y_norm,
        'is_error'                      => (bool) $cctv->is_error,
        'error_description'             => $lastError?->description,
        'last_error_officer_name'       => $lastError?->technician_name,
        'error_reported_at'             => $lastError?->reported_at?->toDateTimeString(),
        'last_maintenance_note'         => $lastMaintenance?->note,
        'last_maintenance_officer_name' => $lastMaintenance?->technician_name,
        'last_maintenance_at'           => $cctv->last_maintenance_at?->toDateTimeString(),
        'visual_status'                 => $cctv->visual_status,
        'maintenance_photo_url'         => $lastMaintenance?->photo
                                            ? Storage::url($lastMaintenance->photo) : null,
        'error_photo_url'               => $lastError?->photo
                                            ? Storage::url($lastError->photo) : null,
        'error_acknowledged_at'         => $cctv->error_acknowledged_at?->toDateTimeString(),
    ];
}
}