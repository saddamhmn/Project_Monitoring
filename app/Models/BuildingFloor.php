<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
class BuildingFloor extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'building_id',
        'floor_number',
        'floor_name',
        'plan_path',
    ];
    
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($floor) {

            if ($floor->isForceDeleting()) {
                $floor->cctvs()->forceDelete();
            } else {
                $floor->cctvs()->delete();
            }

        });
    }

    public function building(): BelongsTo
    {
        return $this->belongsTo(Building::class);
    }
    public function cctvs()
    {
        return $this->hasMany(\App\Models\Cctv::class, 'building_floor_id')->orderBy('name');
    }
}