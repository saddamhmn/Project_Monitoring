<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    // 2024_01_01_000004_create_cctv_maintenance_logs_table.php
public function up(): void
{
    Schema::create('cctv_maintenance_logs', function (Blueprint $table) {
        $table->id();
        $table->foreignId('cctv_id')->constrained()->cascadeOnDelete();
        $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
        $table->string('technician_name');
        $table->text('note')->nullable();
        $table->string('photo')->nullable();
        $table->timestamp('performed_at');
        $table->timestamps();
    });
}
public function down(): void { Schema::dropIfExists('cctv_maintenance_logs'); }
};
