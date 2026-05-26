<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    // 2024_01_01_000001_create_buildings_table.php
public function up(): void
{
    Schema::create('buildings', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->text('description')->nullable();
        $table->decimal('marker_lat', 10, 7);
        $table->decimal('marker_lng', 10, 7);
        $table->decimal('half_lat_delta', 10, 7)->nullable();
        $table->decimal('half_lng_delta', 10, 7)->nullable();
        $table->decimal('north', 10, 7);
        $table->decimal('south', 10, 7);
        $table->decimal('east', 10, 7);
        $table->decimal('west', 10, 7);
        $table->decimal('rotation_deg', 8, 2)->default(0);
        $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
        $table->softDeletes();
        $table->timestamps();
    });
}
public function down(): void { Schema::dropIfExists('buildings'); }
};
