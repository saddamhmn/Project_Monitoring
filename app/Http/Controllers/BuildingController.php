<?php

namespace App\Http\Controllers;

use App\Models\Building;
use App\Models\BuildingFloor;
use App\Models\Cctv;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\OutdoorCctvController;


class BuildingController extends Controller
{
    public function dashboard()
{
    $outdoorCctvs = Cctv::where('is_outdoor', true)
    ->with(['latestMaintenanceLog', 'latestErrorLog'])
    ->get()
    ->map(fn($c) => (new OutdoorCctvController)->transformPublic($c))
    ->values();

    $threshold = Setting::thresholdDue()->toDateTimeString();

    $cctvStats = DB::table('cctvs')
        ->join('building_floors', 'cctvs.building_floor_id', '=', 'building_floors.id')
        ->join('buildings', 'building_floors.building_id', '=', 'buildings.id')
        ->whereNull('buildings.deleted_at')
        ->whereNull('building_floors.deleted_at')
        ->whereNull('cctvs.deleted_at')
        ->select(
            'buildings.id as building_id',
            DB::raw('COUNT(*) as total_cctv'),
            DB::raw('SUM(CASE WHEN cctvs.is_error = TRUE THEN 1 ELSE 0 END) as total_error'),
            DB::raw("SUM(CASE WHEN cctvs.is_error = FALSE AND (cctvs.last_maintenance_at IS NULL OR cctvs.last_maintenance_at < '{$threshold}') THEN 1 ELSE 0 END) as total_unmaintained")
        )
        ->groupBy('buildings.id')
        ->get()
        ->keyBy('building_id');

    $buildings = Building::orderBy('name')->paginate(10);
    $buildings->getCollection()->transform(function ($building) use ($cctvStats) {
        $stats = $cctvStats->get($building->id);
        return [
            'id'               => $building->id,
            'name'             => $building->name,
            'total_cctv'       => (int) ($stats->total_cctv ?? 0),
            'total_error'      => (int) ($stats->total_error ?? 0),
            'total_unmaintained' => (int) ($stats->total_unmaintained ?? 0),
        ];
    });
    $totalCctvAll         = (int) $cctvStats->sum('total_cctv');
    $totalErrorAll        = (int) $cctvStats->sum('total_error');
    $totalUnmaintainedAll = (int) $cctvStats->sum('total_unmaintained');

    $outdoorStats = DB::table('cctvs')
    ->whereNull('deleted_at')
    ->where('is_outdoor', true)
    ->selectRaw("
        COUNT(*) as total_all,
        SUM(CASE WHEN is_error = TRUE THEN 1 ELSE 0 END) as total_error,
        SUM(CASE WHEN is_error = FALSE AND (last_maintenance_at IS NULL OR last_maintenance_at < ?) THEN 1 ELSE 0 END) as total_unmaintained
    ", [$threshold])
    ->first();

$totalOutdoorAll          = (int) ($outdoorStats->total_all          ?? 0);
$totalOutdoorError        = (int) ($outdoorStats->total_error        ?? 0);
$totalOutdoorUnmaintained = (int) ($outdoorStats->total_unmaintained ?? 0);

    return view('dashboard', [
        'mapBuildings' => $this->mapPayload(),
        'outdoorCctvs' => $outdoorCctvs,
        'buildings'                 => $buildings,
        'totalBuildings'            => Building::whereNull('deleted_at')->count(),
        'totalCctvAll'              => $totalCctvAll,
        'totalErrorAll'             => $totalErrorAll,
        'totalUnmaintainedAll'      => $totalUnmaintainedAll,
        'totalOutdoorAll'           => $totalOutdoorAll,
        'totalOutdoorError'         => $totalOutdoorError,
        'totalOutdoorUnmaintained'  => $totalOutdoorUnmaintained,
        'totalCctvGabungan'         => $totalCctvAll + $totalOutdoorAll,
        'totalErrorGabungan'        => $totalErrorAll + $totalOutdoorError,
        'totalUnmaintainedGabungan' => $totalUnmaintainedAll + $totalOutdoorUnmaintained,
    ]);
}

public function index(Request $request)
{
    $threshold = Setting::thresholdDue()->toDateTimeString();


    $cctvStats = DB::table('cctvs')
        ->join('building_floors', 'cctvs.building_floor_id', '=', 'building_floors.id')
        ->join('buildings', 'building_floors.building_id', '=', 'buildings.id')
        ->whereNull('buildings.deleted_at')
        ->whereNull('building_floors.deleted_at')
        ->whereNull('cctvs.deleted_at')
        ->select(
            'buildings.id as building_id',
            DB::raw('COUNT(*) as total_cctv'),
            DB::raw('SUM(CASE WHEN cctvs.is_error = TRUE THEN 1 ELSE 0 END) as total_error'),
            DB::raw("SUM(CASE WHEN cctvs.is_error = FALSE AND (cctvs.last_maintenance_at IS NULL OR cctvs.last_maintenance_at < '{$threshold}') THEN 1 ELSE 0 END) as total_unmaintained")
        )
        ->groupBy('buildings.id')
        ->get()
        ->keyBy('building_id');


    $searchBuilding = $request->search_building;
    $perPage        = in_array($request->per_page, [10, 25, 50, 100]) ? (int)$request->per_page : 10;

    $buildings = Building::orderBy('name')
        ->when($searchBuilding, fn($q) => $q->where('name', 'like', "%{$searchBuilding}%"))
        ->paginate($perPage)
        ->withQueryString();

    $buildings->getCollection()->transform(function ($building) use ($cctvStats) {
        $stats = $cctvStats->get($building->id);
        return [
            'id'                => $building->id,
            'name'              => $building->name,
            'total_cctv'        => (int) ($stats->total_cctv         ?? 0),
            'total_error'       => (int) ($stats->total_error        ?? 0),
            'total_unmaintained'=> (int) ($stats->total_unmaintained ?? 0),
        ];
    });


    $totalCctvAll         = (int) $cctvStats->sum('total_cctv');
    $totalErrorAll        = (int) $cctvStats->sum('total_error');
    $totalUnmaintainedAll = (int) $cctvStats->sum('total_unmaintained');


    $outdoorStats = DB::table('cctvs')
        ->whereNull('deleted_at')->where('is_outdoor', true)
        ->selectRaw("
            COUNT(*) as total_all,
            SUM(CASE WHEN is_error = TRUE THEN 1 ELSE 0 END) as total_error,
            SUM(CASE WHEN is_error = FALSE AND (last_maintenance_at IS NULL OR last_maintenance_at < ?) THEN 1 ELSE 0 END) as total_unmaintained
        ", [$threshold])->first();

    $totalOutdoorAll          = (int) ($outdoorStats->total_all          ?? 0);
    $totalOutdoorError        = (int) ($outdoorStats->total_error        ?? 0);
    $totalOutdoorUnmaintained = (int) ($outdoorStats->total_unmaintained ?? 0);

    $searchIndoor  = $request->search_indoor;
    $indoorPerPage = in_array($request->indoor_per_page, [10, 25, 50, 100])
        ? (int)$request->indoor_per_page : 10;

    $indoorCctvs = Cctv::select('cctvs.*')
        ->join('building_floors as bf', 'cctvs.building_floor_id', '=', 'bf.id')
        ->join('buildings as b', 'bf.building_id', '=', 'b.id')
        ->whereNull('cctvs.deleted_at')
        ->whereNull('bf.deleted_at')
        ->whereNull('b.deleted_at')
        ->where('cctvs.is_outdoor', false)
        ->when($searchIndoor, fn($q) => $q->where(function ($q2) use ($searchIndoor) {
            $q2->where('cctvs.name', 'like', "%{$searchIndoor}%")
               ->orWhere('cctvs.ip_address', 'like', "%{$searchIndoor}%");
        }))
        ->orderBy('b.name')
        ->orderBy('bf.floor_number')
        ->orderBy('cctvs.name')
        ->with(['floor', 'floor.building'])
        ->paginate($indoorPerPage, ['*'], 'indoor_page')
        ->withQueryString();

    $searchOutdoor  = $request->search_outdoor;
    $outdoorPerPage = in_array($request->outdoor_per_page, [10, 25, 50, 100])
        ? (int)$request->outdoor_per_page : 10;

    $outdoorCctvs = Cctv::where('is_outdoor', true)
        ->whereNull('deleted_at')
        ->when($searchOutdoor, fn($q) => $q->where(function ($q2) use ($searchOutdoor) {
            $q2->where('name', 'like', "%{$searchOutdoor}%")
               ->orWhere('ip_address', 'like', "%{$searchOutdoor}%");
        }))
        ->orderByRaw("CASE WHEN is_error THEN 0 WHEN last_maintenance_at IS NULL THEN 1 ELSE 2 END")
        ->paginate($outdoorPerPage, ['*'], 'outdoor_page')
        ->withQueryString();

    return view('buildings.monitoring', [
        'buildings'                 => $buildings,
        'indoorCctvs'               => $indoorCctvs,
        'outdoorCctvs'              => $outdoorCctvs,
        'totalBuildings'            => Building::whereNull('deleted_at')->count(),
        'totalCctvAll'              => $totalCctvAll,
        'totalErrorAll'             => $totalErrorAll,
        'totalUnmaintainedAll'      => $totalUnmaintainedAll,
        'totalOutdoorAll'           => $totalOutdoorAll,
        'totalOutdoorError'         => $totalOutdoorError,
        'totalOutdoorUnmaintained'  => $totalOutdoorUnmaintained,
        'totalCctvGabungan'         => $totalCctvAll + $totalOutdoorAll,
        'totalErrorGabungan'        => $totalErrorAll + $totalOutdoorError,
        'totalUnmaintainedGabungan' => $totalUnmaintainedAll + $totalOutdoorUnmaintained,
        'searchBuilding'            => $searchBuilding ?? '',
        'searchIndoor'              => $searchIndoor   ?? '',
        'searchOutdoor'             => $searchOutdoor  ?? '',
        'indoorPerPage'             => $indoorPerPage,
        'outdoorPerPage'            => $outdoorPerPage,
    ]);
}

    public function store(Request $request)
    {
        $validated = $this->validateBuilding($request);

        DB::transaction(function () use ($request, $validated) {
            $building = Building::create([
                'name' => $validated['name'],
                'description' => $validated['description'] ?? null,

                'marker_lat' => $validated['marker_lat'],
                'marker_lng' => $validated['marker_lng'],

                'half_lat_delta' => $validated['half_lat_delta'] ?? null,
                'half_lng_delta' => $validated['half_lng_delta'] ?? null,
                'rotation_deg' => $validated['rotation_deg'] ?? 0,

                'north' => $validated['north'],
                'south' => $validated['south'],
                'east' => $validated['east'],
                'west' => $validated['west'],

                'user_id' => auth()->id(),
            ]);

            $this->syncFloors($request, $building, false);
        });

        return redirect()->route('dashboard')->with('success', 'Gedung berhasil ditambahkan.');
    }

    public function update(Request $request, Building $building)
    {
        $validated = $this->validateBuilding($request);

        DB::transaction(function () use ($request, $validated, $building) {
            $building->update([
                'name' => $validated['name'],
                'description' => $validated['description'] ?? null,

                'marker_lat' => $validated['marker_lat'],
                'marker_lng' => $validated['marker_lng'],

                'half_lat_delta' => $validated['half_lat_delta'] ?? $building->half_lat_delta,
                'half_lng_delta' => $validated['half_lng_delta'] ?? $building->half_lng_delta,
                'rotation_deg' => $validated['rotation_deg'] ?? 0,

                'north' => $validated['north'],
                'south' => $validated['south'],
                'east' => $validated['east'],
                'west' => $validated['west'],
            ]);

            $this->syncFloors($request, $building, true);
        });

        return redirect()->route('dashboard')->with('success', 'Gedung berhasil diubah.');
    }

    public function maintenance(Building $building)
    {
        $building->load('floors');

        return view('buildings.maintenance', compact('building'));
    }

    private function validateBuilding(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],

            'marker_lat' => ['required', 'numeric'],
            'marker_lng' => ['required', 'numeric'],


            'half_lat_delta' => ['nullable', 'numeric'],
            'half_lng_delta' => ['nullable', 'numeric'],
            'rotation_deg' => ['nullable', 'numeric'],


            'north' => ['required', 'numeric'],
            'south' => ['required', 'numeric'],
            'east' => ['required', 'numeric'],
            'west' => ['required', 'numeric'],


            'floors' => ['nullable', 'array'],
            'floors.*.floor_number' => ['nullable', 'integer', 'min:0'],
            'floors.*.floor_name' => ['nullable', 'string', 'max:255'],
            'floors.*.existing_plan' => ['nullable', 'string'],
            'floors.*.plan_file' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,pdf', 'max:10240'],
        ]);
    }

    private function syncFloors(Request $request, Building $building, bool $isUpdate): void
{
    $submittedIds = [];
    $keptPaths    = [];

    foreach (($request->input('floors', []) ?? []) as $i => $row) {
        $floorNumber  = $row['floor_number'] ?? null;
        $floorName    = $row['floor_name']   ?? null;
        $floorId      = isset($row['floor_id']) && $row['floor_id'] !== ''
                            ? (int) $row['floor_id'] : null;
        $uploadedFile = $request->file("floors.$i.plan_file");
        $existingPlan = $row['existing_plan'] ?? null;


        if ($floorNumber === null && $floorNumber !== '0'
            && !$floorName && !$uploadedFile && !$existingPlan) {
            continue;
        }

        if ($floorNumber === null || $floorNumber === '') {
            continue;
        }

        $planPath = $existingPlan ?: null;

        if ($uploadedFile) {
            $planPath = $uploadedFile->store('building-plans', 'public');
        }

        if ($planPath) {
            $keptPaths[] = $planPath;
        }

        if ($floorId) {
 
            $floor = BuildingFloor::find($floorId);
            if ($floor && $floor->building_id === $building->id) {
                if ($uploadedFile && $floor->plan_path && $floor->plan_path !== $planPath) {
                    Storage::disk('public')->delete($floor->plan_path);
                }
                $floor->update([
                    'floor_number' => (int) $floorNumber,
                    'floor_name'   => $floorName ?: null,
                    'plan_path'    => $planPath,
                ]);
                $submittedIds[] = $floor->id;
            }
        } else {
            $floor = BuildingFloor::create([
                'building_id'  => $building->id,
                'floor_number' => (int) $floorNumber,
                'floor_name'   => $floorName ?: null,
                'plan_path'    => $planPath,
            ]);
            $submittedIds[] = $floor->id;
        }
    }

    if ($isUpdate) {
        $toDelete = BuildingFloor::where('building_id', $building->id)
            ->whereNull('deleted_at')
            ->when(!empty($submittedIds), fn($q) => $q->whereNotIn('id', $submittedIds))
            ->get();

        foreach ($toDelete as $floor) {
            if ($floor->plan_path && !in_array($floor->plan_path, $keptPaths)) {
                Storage::disk('public')->delete($floor->plan_path);
            }
            $floor->delete();
        }
    }
}

    private function mapPayload()
{
    $threshold = Setting::thresholdDue()->toDateTimeString();

    $cctvStats = DB::table('cctvs')
        ->join('building_floors', 'cctvs.building_floor_id', '=', 'building_floors.id')
        ->join('buildings', 'building_floors.building_id', '=', 'buildings.id')
        ->whereNull('buildings.deleted_at')
        ->whereNull('building_floors.deleted_at')
        ->whereNull('cctvs.deleted_at')
        ->where('cctvs.is_outdoor', false)
        ->select(
            'buildings.id as building_id',
            DB::raw('COUNT(*) as total_cctv'),
            DB::raw('SUM(CASE WHEN cctvs.is_error = TRUE THEN 1 ELSE 0 END) as total_error'),
            DB::raw("SUM(CASE WHEN cctvs.is_error = FALSE AND (cctvs.last_maintenance_at IS NULL OR cctvs.last_maintenance_at < '{$threshold}') THEN 1 ELSE 0 END) as total_unmaintained")
        )
        ->groupBy('buildings.id')
        ->get()
        ->keyBy('building_id');

    $buildings = Building::with('floors')->get();

    return $buildings->map(function ($b) use ($cctvStats) {
        $halfLat = $b->half_lat_delta;
        $halfLng = $b->half_lng_delta;
        if (($halfLat === null || $halfLng === null) && $b->north !== null) {
            $halfLat = abs(((float)$b->north - (float)$b->south) / 2);
            $halfLng = abs(((float)$b->east  - (float)$b->west)  / 2);
        }

        $stats = $cctvStats->get($b->id);

        return [
            'id'               => $b->id,
            'name'             => $b->name,
            'description'      => $b->description,
            'marker_lat'       => (float) $b->marker_lat,
            'marker_lng'       => (float) $b->marker_lng,
            'half_lat_delta'   => $halfLat !== null ? (float) $halfLat : null,
            'half_lng_delta'   => $halfLng !== null ? (float) $halfLng : null,
            'rotation_deg'     => (float) ($b->rotation_deg ?? 0),
            'north'            => (float) $b->north,
            'south'            => (float) $b->south,
            'east'             => (float) $b->east,
            'west'             => (float) $b->west,
            'total_cctv'       => (int) ($stats->total_cctv       ?? 0),
            'total_error'      => (int) ($stats->total_error      ?? 0),
            'total_unmaintained' => (int) ($stats->total_unmaintained ?? 0),
            'maintenance_url'  => route('dashboard.buildings.maintenance', ['building' => $b->id, 'from' => 'dashboard']),
            'floors'           => $b->floors->map(fn($f) => [
                'id'           => $f->id,
                'floor_number' => $f->floor_number,
                'floor_name'   => $f->floor_name,
                'plan_path'    => $f->plan_path,
                'plan_url'     => $f->plan_path ? Storage::url($f->plan_path) : null,
            ])->values(),
        ];
    })->values();
}
    public function destroy(Building $building)
{
    $building->delete();

    return redirect()->route('dashboard')
        ->with('success', 'Gedung berhasil dihapus.');
}
    
    
}