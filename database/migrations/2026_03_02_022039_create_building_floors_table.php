<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    // 2024_01_01_000002_create_building_floors_table.php
public function up(): void
{
    Schema::create('building_floors', function (Blueprint $table) {
        $table->id();
        $table->foreignId('building_id')->constrained()->cascadeOnDelete();
        $table->unsignedSmallInteger('floor_number');
        $table->string('floor_name')->nullable();
        $table->string('plan_path')->nullable();
        $table->softDeletes();
        $table->timestamps();
    });
}
public function down(): void { Schema::dropIfExists('building_floors'); }
};
