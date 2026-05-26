<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cctv extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'is_outdoor',
        'building_id', 'building_floor_id',
        'x_norm', 'y_norm',
        'lat', 'lng',
        'name', 'ip_address', 'cctv_type', 'description',
        'is_error',
        'last_maintenance_at',
        'last_maintained_by_user_id',
        'error_acknowledged_at',        
        'error_acknowledged_by_user_id',
    ];

    protected $casts = [
        'is_outdoor'          => 'boolean',
        'x_norm'              => 'float',
        'y_norm'              => 'float',
        'lat'                 => 'float',
        'lng'                 => 'float',
        'is_error'            => 'boolean',
        'last_maintenance_at' => 'datetime',
        'error_acknowledged_at'    => 'datetime',
    ];



    public function building(): BelongsTo
    {
        return $this->belongsTo(Building::class);
    }

    public function floor(): BelongsTo
    {
        return $this->belongsTo(BuildingFloor::class, 'building_floor_id');
    }

    public function maintainedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'last_maintained_by_user_id');
    }

    public function maintenanceLogs(): HasMany
    {
        return $this->hasMany(CctvMaintenanceLog::class)->latest('performed_at');
    }

    public function errorLogs(): HasMany
    {
        return $this->hasMany(CctvErrorLog::class)->latest('reported_at');
    }

    public function latestMaintenanceLog(): \Illuminate\Database\Eloquent\Relations\HasOne
{
    return $this->hasOne(CctvMaintenanceLog::class)
                ->latestOfMany('performed_at');
}

    public function latestErrorLog(): \Illuminate\Database\Eloquent\Relations\HasOne
{
    return $this->hasOne(CctvErrorLog::class)
                ->latestOfMany('reported_at');
}


    public function getVisualStatusAttribute(): string
{
    if ($this->is_error) return 'error';
    if (!$this->last_maintenance_at) return 'overdue';

    $dueHours     = \App\Models\Setting::dueHours();
    $overdueHours = \App\Models\Setting::overdueHours();

    $diffHours = now()->diffInHours($this->last_maintenance_at, false);


    if ($diffHours <= -$overdueHours) return 'overdue';
    if ($diffHours <= -$dueHours)     return 'due';
    return 'normal';
}
}