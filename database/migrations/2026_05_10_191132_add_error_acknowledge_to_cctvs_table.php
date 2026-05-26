<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::table('cctvs', function (Blueprint $table) {
        $table->timestamp('error_acknowledged_at')->nullable()->after('is_error');
        $table->foreignId('error_acknowledged_by_user_id')
              ->nullable()->constrained('users')->nullOnDelete()
              ->after('error_acknowledged_at');
    });
}

public function down(): void
{
    Schema::table('cctvs', function (Blueprint $table) {
        $table->dropForeign(['error_acknowledged_by_user_id']);
        $table->dropColumn(['error_acknowledged_at', 'error_acknowledged_by_user_id']);
    });
}
};
