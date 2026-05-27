<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            [
                'key'         => 'threshold_due_hours',
                'value'       => '24',
                'label'       => 'Threshold Due',
                'description' => 'Jam sebelum CCTV berstatus Perlu Maintenance',
            ],
            [
                'key'         => 'threshold_overdue_hours',
                'value'       => '72',
                'label'       => 'Threshold Overdue',
                'description' => 'Jam sebelum CCTV berstatus Overdue',
            ],
            [
                'key'         => 'color_due',
                'value'       => '#f97316',
                'label'       => 'Warna Perlu Maintenance',
                'description' => 'Warna marker CCTV berstatus due (orange default)',
            ],
            [
                'key'         => 'color_overdue',
                'value'       => '#ef4444',
                'label'       => 'Warna Overdue',
                'description' => 'Warna marker CCTV berstatus overdue (merah default)',
            ],
            [
                'key'         => 'ack_reset_time',
                'value'       => '10:00',
                'label'       => 'Jam Reset Acknowledge',
                'description' => 'Jam harian untuk reset acknowledge notifikasi error',
            ],
        ];

        foreach ($settings as $setting) {
            DB::table('settings')->updateOrInsert(
                ['key' => $setting['key']],
                array_merge($setting, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ])
            );
        }

        $this->command->info('✓ Settings seeded (5 setting default)');
    }
}