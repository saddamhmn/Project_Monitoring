<?php

namespace App\Http\Controllers;

use App\Models\Cctv;
use App\Models\CctvMaintenanceLog;
use App\Models\CctvErrorLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OutdoorCctvController extends Controller
{
    public function index()
{
    $cctvs = Cctv::where('is_outdoor', true)
        ->with(['latestMaintenanceLog', 'latestErrorLog'])
        ->get()
        ->map(fn($c) => $this->transform($c));

    return response()->json($cctvs);
}

    public function store(Request $request)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'lat'        => 'required|numeric',
            'lng'        => 'required|numeric',
            'cctv_type'  => 'required|in:dome,bullet,ptz',
            'ip_address' => 'nullable|string|max:45',
        ]);

        $cctv = Cctv::create([
            'is_outdoor' => true,
            'name'       => $request->name,
            'lat'        => $request->lat,
            'lng'        => $request->lng,
            'cctv_type'  => $request->cctv_type,
            'ip_address' => $request->ip_address,
            'last_maintenance_at' => now(),
        ]);

        return response()->json(['cctv' => $this->transform($cctv)], 201);
    }

    public function destroy(Cctv $cctv)
    {
        abort_if(!$cctv->is_outdoor, 404);
        $cctv->delete();
        return response()->json(['ok' => true]);
    }

    public function markMaintenance(Request $request, Cctv $cctv)
    {
        abort_if(!$cctv->is_outdoor, 404);

        $request->validate([
            'technician_name' => 'required|string|max:255',
            'photo'           => 'required|image|max:5120',
            'note'            => 'nullable|string',
        ]);

        $photoPath = $request->file('photo')
            ->store('outdoor-maintenance', 'public');

        CctvMaintenanceLog::create([
            'cctv_id'          => $cctv->id,
            'user_id'          => auth()->id(),
            'technician_name'  => $request->technician_name,
            'note'             => $request->note,
            'photo'            => $photoPath,
            'performed_at'     => now(),
        ]);

        $cctv->update([
    'is_error'                       => false,
    'last_maintenance_at'            => now(),
    'error_acknowledged_at'          => null,
    'error_acknowledged_by_user_id'  => null,
]);

        return response()->json(['cctv' => $this->transform($cctv->fresh())]);
    }

    public function markError(Request $request, Cctv $cctv)
    {
        abort_if(!$cctv->is_outdoor, 404);

        $request->validate([
            'technician_name' => 'required|string|max:255',
            'description'     => 'required|string',
            'photo'           => 'required|image|max:5120',
        ]);

        $photoPath = $request->file('photo')
            ->store('outdoor-errors', 'public');

        CctvErrorLog::create([
            'cctv_id'          => $cctv->id,
            'user_id'          => auth()->id(),
            'technician_name'  => $request->technician_name,
            'description'      => $request->description,
            'photo'            => $photoPath,
            'reported_at'      => now(),
        ]);

        $cctv->update([
    'is_error'                       => true,
    'last_maintenance_at'            => now(),
    'error_acknowledged_at'          => null,
    'error_acknowledged_by_user_id'  => null,
]);

        return response()->json(['cctv' => $this->transform($cctv->fresh())]);
    }



    private function transform(Cctv $cctv): array
{
    $lastMaintenance = $cctv->relationLoaded('latestMaintenanceLog')
        ? $cctv->latestMaintenanceLog
        : $cctv->maintenanceLogs()->first();

    $lastError = $cctv->relationLoaded('latestErrorLog')
        ? $cctv->latestErrorLog
        : $cctv->errorLogs()->first();

    return [
        'id'                       => $cctv->id,
        'name'                     => $cctv->name,
        'ip_address'               => $cctv->ip_address,
        'cctv_type'                => $cctv->cctv_type,
        'lat'                      => $cctv->lat,
        'lng'                      => $cctv->lng,
        'is_error'                 => $cctv->is_error,
        'last_maintenance_at'      => $cctv->last_maintenance_at?->toDateTimeString(),
        'visual_status'            => $cctv->visual_status,
        'last_maintenance_note'    => $lastMaintenance?->note,
        'last_maintenance_officer' => $lastMaintenance?->technician_name,
        'maintenance_photo_url'    => $lastMaintenance?->photo
                                        ? Storage::url($lastMaintenance->photo) : null,
        'error_description'        => $lastError?->description,
        'last_error_officer'       => $lastError?->technician_name,
        'error_photo_url'          => $lastError?->photo
                                        ? Storage::url($lastError->photo) : null,
        'error_acknowledged_at'    => $cctv->error_acknowledged_at?->toDateTimeString(),
    ];
}

    public function transformPublic(Cctv $cctv): array
    {
        return $this->transform($cctv);
    }
}