<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    // 2024_01_01_000003_create_cctvs_table.php
public function up(): void
{
    Schema::create('cctvs', function (Blueprint $table) {
        $table->id();

        // ── TIPE: indoor atau outdoor ──────────────────
        $table->boolean('is_outdoor')->default(false);

        // ── INDOOR ONLY (nullable untuk outdoor) ───────
        $table->foreignId('building_id')
              ->nullable()->constrained()->nullOnDelete();
        $table->foreignId('building_floor_id')
              ->nullable()
              ->references('id')->on('building_floors')
              ->nullOnDelete();
        $table->decimal('x_norm', 8, 6)->nullable();
        $table->decimal('y_norm', 8, 6)->nullable();

        // ── OUTDOOR ONLY (nullable untuk indoor) ───────
        $table->decimal('lat', 10, 7)->nullable();
        $table->decimal('lng', 10, 7)->nullable();

        // ── SHARED ──────────────────────────────────────
        $table->string('name');
        $table->string('ip_address', 45)->nullable();
        $table->enum('cctv_type', ['dome', 'bullet', 'ptz'])->default('dome');
        $table->text('description')->nullable();
        $table->boolean('is_error')->default(false);
        $table->timestamp('last_maintenance_at')->nullable();
        $table->foreignId('last_maintained_by_user_id')
              ->nullable()->constrained('users')->nullOnDelete();

        $table->softDeletes();
        $table->timestamps();
    });
}
public function down(): void { Schema::dropIfExists('cctvs'); }
};

