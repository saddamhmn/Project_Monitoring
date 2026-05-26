<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LogsExport;

class LogController extends Controller
{
    public function index(Request $request)
    {
        $maintenance = DB::table('cctv_maintenance_logs')
            ->leftJoin('cctvs', 'cctv_maintenance_logs.cctv_id', '=', 'cctvs.id')
            ->leftJoin('buildings', 'cctvs.building_id', '=', 'buildings.id')
            ->leftJoin('building_floors', 'cctvs.building_floor_id', '=', 'building_floors.id')
            ->select(
                'buildings.id as building_id',
                DB::raw("CASE WHEN cctvs.is_outdoor THEN 'Area Outdoor'
                              ELSE COALESCE(buildings.name, '[Gedung Dihapus]')
                         END as building"),
                DB::raw("CASE WHEN cctvs.is_outdoor THEN '-'
                              ELSE COALESCE(CAST(building_floors.floor_number AS TEXT), '-')
                         END as floor"),
                DB::raw("COALESCE(cctvs.name, '[CCTV Dihapus]') as cctv_name"),
                DB::raw("COALESCE(cctvs.cctv_type, '-') as cctv_type"),
                DB::raw("'maintenance' as type"),
                DB::raw("CASE WHEN cctvs.is_outdoor THEN 'outdoor' ELSE 'indoor' END as area"),
                'cctv_maintenance_logs.technician_name as petugas',
                'cctv_maintenance_logs.note as keterangan',
                'cctv_maintenance_logs.photo as photo',
                'cctv_maintenance_logs.performed_at as created_at',
                DB::raw("CASE WHEN cctvs.deleted_at IS NOT NULL THEN 1 ELSE 0 END as cctv_deleted"),
                DB::raw("CASE WHEN buildings.deleted_at IS NOT NULL THEN 1 ELSE 0 END as building_deleted")
            );

        $error = DB::table('cctv_error_logs')
            ->leftJoin('cctvs', 'cctv_error_logs.cctv_id', '=', 'cctvs.id')
            ->leftJoin('buildings', 'cctvs.building_id', '=', 'buildings.id')
            ->leftJoin('building_floors', 'cctvs.building_floor_id', '=', 'building_floors.id')
            ->select(
                'buildings.id as building_id',
                DB::raw("CASE WHEN cctvs.is_outdoor THEN 'Area Outdoor'
                              ELSE COALESCE(buildings.name, '[Gedung Dihapus]')
                         END as building"),
                DB::raw("CASE WHEN cctvs.is_outdoor THEN '-'
                              ELSE COALESCE(CAST(building_floors.floor_number AS TEXT), '-')
                         END as floor"),
                DB::raw("COALESCE(cctvs.name, '[CCTV Dihapus]') as cctv_name"),
                DB::raw("COALESCE(cctvs.cctv_type, '-') as cctv_type"),
                DB::raw("'error' as type"),
                DB::raw("CASE WHEN cctvs.is_outdoor THEN 'outdoor' ELSE 'indoor' END as area"),
                'cctv_error_logs.technician_name as petugas',
                'cctv_error_logs.description as keterangan',
                'cctv_error_logs.photo as photo',
                'cctv_error_logs.reported_at as created_at',
                DB::raw("CASE WHEN cctvs.deleted_at IS NOT NULL THEN 1 ELSE 0 END as cctv_deleted"),
                DB::raw("CASE WHEN buildings.deleted_at IS NOT NULL THEN 1 ELSE 0 END as building_deleted")
            );

        if ($request->filled('building')) {
            $maintenance->where('buildings.id', $request->building)
                        ->where('cctvs.is_outdoor', false);
            $error->where('buildings.id', $request->building)
                  ->where('cctvs.is_outdoor', false);
        }

        if ($request->filled('floor')) {
            $maintenance->where('building_floors.floor_number', $request->floor);
            $error->where('building_floors.floor_number', $request->floor);
        }

        if ($request->filled('cctv_type')) {
            $maintenance->where('cctvs.cctv_type', $request->cctv_type);
            $error->where('cctvs.cctv_type', $request->cctv_type);
        }

        $logs = DB::query()->fromSub($maintenance->unionAll($error), 'logs');

        if ($request->filled('area'))     $logs->where('area', $request->area);
        if ($request->filled('log_type')) $logs->where('type', $request->log_type);
        if ($request->filled('petugas'))  $logs->where('petugas', 'like', '%'.$request->petugas.'%');

        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $logs->where('cctv_deleted', 0)->where('building_deleted', 0);
            } elseif ($request->status === 'deleted') {
                $logs->where(fn($q) => $q->where('cctv_deleted', 1)->orWhere('building_deleted', 1));
            }
        }

        if ($request->filled('date_from') && $request->filled('date_to')) {
            $logs->whereDate('created_at', '>=', $request->date_from)
                 ->whereDate('created_at', '<=', $request->date_to);
        } elseif ($request->filled('date_from')) {
            $logs->whereDate('created_at', '>=', $request->date_from);
        } elseif ($request->filled('range')) {
            match($request->range) {
                'week'    => $logs->where('created_at', '>=', now()->subWeek()),
                'month'   => $logs->where('created_at', '>=', now()->startOfMonth()),
                '3months' => $logs->where('created_at', '>=', now()->subMonths(3)),
                default   => null,
            };
        }

        $perPage = in_array($request->per_page, [10, 25, 50, 100]) ? (int)$request->per_page : 10;
        $logs = $logs->orderBy('created_at', 'desc')->paginate($perPage)->appends($request->query());

        $buildings = DB::table('buildings')->whereNull('deleted_at')->orderBy('name')->get();
        $floors = DB::table('building_floors')
        ->join('buildings', 'building_floors.building_id', '=', 'buildings.id')
        ->whereNull('building_floors.deleted_at')
        ->whereNull('buildings.deleted_at')
        ->select('building_floors.floor_number')
        ->distinct()
        ->orderBy('building_floors.floor_number')
        ->get();
            return view('log', compact('logs', 'buildings', 'floors'));
        }

    public function export(Request $request)
    {
        return Excel::download(new LogsExport($request), 'logs.xlsx');
    }
}