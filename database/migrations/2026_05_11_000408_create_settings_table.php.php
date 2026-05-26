<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->string('label')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // Default values
        DB::table('settings')->insert([
            [
                'key'         => 'threshold_due_hours',
                'value'       => '24',
                'label'       => 'Threshold Due',
                'description' => 'Jam sebelum CCTV berstatus Perlu Maintenance',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'key'         => 'threshold_overdue_hours',
                'value'       => '72',
                'label'       => 'Threshold Overdue',
                'description' => 'Jam sebelum CCTV berstatus Overdue',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};