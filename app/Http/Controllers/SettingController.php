<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->keyBy('key');

        return view('settings', [
            'thresholdDueHours'     => (int) ($settings['threshold_due_hours']->value     ?? 24),
            'thresholdOverdueHours' => (int) ($settings['threshold_overdue_hours']->value ?? 72),
            'appName'               => $settings['app_name']->value     ?? 'Dhoho CCTV Monitor',
            'airportName'           => $settings['airport_name']->value ?? 'Bandara Dhoho Kediri',
            'notifResetHour' => (int) ($settings['notif_reset_hour']->value ?? 10),
            'colorDue'     => Setting::get('color_due',     '#f97316'),
'colorOverdue' => Setting::get('color_overdue', '#ef4444'),
        ]);
    }

    public function updateThreshold(Request $request)
    {
        $request->validate([
            'due_value'     => ['required', 'integer', 'min:1'],
            'due_unit'      => ['required', 'in:jam,hari,bulan'],
            'overdue_value' => ['required', 'integer', 'min:1'],
            'overdue_unit'  => ['required', 'in:jam,hari,bulan'],
        ]);

        $dueHours     = $this->toHours($request->due_value, $request->due_unit);
        $overdueHours = $this->toHours($request->overdue_value, $request->overdue_unit);

        if ($overdueHours <= $dueHours) {
            return back()
                ->withErrors(['overdue' => 'Threshold Overdue harus lebih besar dari Threshold Due.'])
                ->withInput()
                ->with('active_tab', 'threshold');
        }

        Setting::set('threshold_due_hours',     (string) $dueHours);
        Setting::set('threshold_overdue_hours', (string) $overdueHours);
        Setting::clearCache();

        return back()->with('success', 'Threshold berhasil disimpan.')->with('active_tab', 'threshold');
    }
    public function updateColors(Request $request)
{
    $request->validate([
        'color_due'     => ['required', 'regex:/^#[0-9a-fA-F]{6}$/'],
        'color_overdue' => ['required', 'regex:/^#[0-9a-fA-F]{6}$/'],
    ]);

    Setting::set('color_due',     $request->color_due);
    Setting::set('color_overdue', $request->color_overdue);
    Setting::clearCache();

    return back()->with('success', 'Warna status berhasil disimpan.');
}

    public function updateAckReset(Request $request)
{
    $request->validate([
        'ack_reset_time' => ['required', 'regex:/^\d{2}:\d{2}$/'],
    ]);

    Setting::set('ack_reset_time', $request->ack_reset_time);
    Setting::clearCache();

    return back()->with('success', 'Jam reset acknowledge berhasil disimpan.');
}


    private function toHours(int $value, string $unit): int
    {
        return match ($unit) {
            'bulan' => $value * 720,
            'hari'  => $value * 24,
            default => $value,
        };
    }
}