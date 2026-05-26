<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CctvSseController extends Controller
{
    public function stream(Request $request)
    {
        // Endpoint JSON biasa, tidak ada while loop
        return response()->json($this->getCurrentSnapshot());
    }

    private function getCurrentSnapshot(): array
    {
        $threshold = Setting::thresholdDue()->toDateTimeString();

        $outdoorStats = DB::table('cctvs')
            ->whereNull('deleted_at')
            ->where('is_outdoor', true)
            ->selectRaw("
                COUNT(*) as total_all,
                SUM(CASE WHEN is_error = TRUE THEN 1 ELSE 0 END) as total_error,
                SUM(CASE WHEN is_error = FALSE AND (last_maintenance_at IS NULL OR last_maintenance_at < ?) THEN 1 ELSE 0 END) as total_unmaintained
            ", [$threshold])
            ->first();

        $indoorStats = DB::table('cctvs')
            ->join('building_floors', 'cctvs.building_floor_id', '=', 'building_floors.id')
            ->join('buildings', 'building_floors.building_id', '=', 'buildings.id')
            ->whereNull('buildings.deleted_at')
            ->whereNull('building_floors.deleted_at')
            ->whereNull('cctvs.deleted_at')
            ->selectRaw("
                COUNT(*) as total_cctv,
                SUM(CASE WHEN cctvs.is_error = TRUE THEN 1 ELSE 0 END) as total_error,
                SUM(CASE WHEN cctvs.is_error = FALSE AND (cctvs.last_maintenance_at IS NULL OR cctvs.last_maintenance_at < ?) THEN 1 ELSE 0 END) as total_unmaintained
            ", [$threshold])
            ->first();

        $buildingStats = DB::table('cctvs')
            ->join('building_floors', 'cctvs.building_floor_id', '=', 'building_floors.id')
            ->join('buildings', 'building_floors.building_id', '=', 'buildings.id')
            ->whereNull('buildings.deleted_at')
            ->whereNull('building_floors.deleted_at')
            ->whereNull('cctvs.deleted_at')
            ->select(
                'buildings.id as building_id',
                DB::raw('SUM(CASE WHEN cctvs.is_error = TRUE THEN 1 ELSE 0 END) as total_error'),
                DB::raw("SUM(CASE WHEN cctvs.is_error = FALSE AND (cctvs.last_maintenance_at IS NULL OR cctvs.last_maintenance_at < '{$threshold}') THEN 1 ELSE 0 END) as total_unmaintained")
            )
            ->groupBy('buildings.id')
            ->get()
            ->keyBy('building_id');

        return [
            'ts'                        => time(),
            'totalOutdoorError'         => (int) ($outdoorStats->total_error ?? 0),
            'totalOutdoorUnmaintained'  => (int) ($outdoorStats->total_unmaintained ?? 0),
            'totalIndoorError'          => (int) ($indoorStats->total_error ?? 0),
            'totalIndoorUnmaintained'   => (int) ($indoorStats->total_unmaintained ?? 0),
            'totalErrorGabungan'        => (int) (($indoorStats->total_error ?? 0) + ($outdoorStats->total_error ?? 0)),
            'totalUnmaintainedGabungan' => (int) (($indoorStats->total_unmaintained ?? 0) + ($outdoorStats->total_unmaintained ?? 0)),
            'buildingStats'             => $buildingStats->map(fn($b) => [
                'total_error'        => (int) $b->total_error,
                'total_unmaintained' => (int) $b->total_unmaintained,
            ])->toArray(),
        ];
    }
}