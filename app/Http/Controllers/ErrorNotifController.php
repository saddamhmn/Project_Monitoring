<?php

namespace App\Http\Controllers;

use App\Models\Cctv;
use App\Models\Setting;
use Illuminate\Http\Request;

class ErrorNotifController extends Controller
{
    public function index()
    {
        $resetTimeStr = Setting::get('ack_reset_time', '10:00');
        [$rH, $rM]    = explode(':', $resetTimeStr);
        $now          = now();
        $resetToday   = now()->setTime((int)$rH, (int)$rM, 0);
        $lastReset    = $now->gte($resetToday) ? $resetToday : $resetToday->subDay();

        $errors = Cctv::where('is_error', true)
            ->whereNull('cctvs.deleted_at')
            ->where(function ($q) use ($lastReset) {
                $q->whereNull('error_acknowledged_at')
                  ->orWhere('error_acknowledged_at', '<', $lastReset);
            })

            ->where(function ($q) {
                $q->where('is_outdoor', true)
                  ->orWhere(function ($q2) {
                      $q2->where('is_outdoor', false)
                         ->whereHas('floor', function ($q3) {       
                             $q3->whereNull('building_floors.deleted_at')
                                ->whereHas('building', function ($q4) {
                                    $q4->whereNull('buildings.deleted_at');
                                });
                         });
                  });
            })

            ->with(['floor.building'])
            ->get()
            ->map(function ($cctv) {
                $location = $cctv->is_outdoor
                    ? 'Outdoor'
                    : optional($cctv->floor?->building)->name ?? 'Indoor';

                return [
                    'id'                    => $cctv->id,
                    'cctv_name'             => $cctv->name,
                    'location'              => $location,
                    'is_outdoor'            => $cctv->is_outdoor,
                    'reported_at'           => $cctv->updated_at?->toDateTimeString(),
                    'error_acknowledged_at' => $cctv->error_acknowledged_at?->toDateTimeString(),
                ];
            });

        return response()->json($errors);
    }

    public function acknowledge(Cctv $cctv)
    {
        $cctv->update([
            'error_acknowledged_at'         => now(),
            'error_acknowledged_by_user_id' => auth()->id(),
        ]);

        return response()->json(['ok' => true]);
    }
}