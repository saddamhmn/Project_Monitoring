<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Building extends Model
{
    use SoftDeletes;

    protected $fillable = [
        
        'name',
        'description',
        'marker_lat',
        'marker_lng',
        'half_lat_delta',
        'half_lng_delta',
        'north',
        'south',
        'east',
        'west',
        'rotation_deg',
        'user_id',
    ];

    protected $casts = [
        'marker_lat' => 'float',
        'marker_lng' => 'float',
        'half_lat_delta' => 'float',
        'half_lng_delta' => 'float',
        'north' => 'float',
        'south' => 'float',
        'east' => 'float',
        'west' => 'float',
        'rotation_deg' => 'float',
        'deleted_at' => 'datetime',
    ];
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($building) {

            if ($building->isForceDeleting()) {
                $building->floors()->forceDelete();
            } else {
                $building->floors()->delete();
            }

        });
    }

    public function floors(): HasMany
    {
        return $this->hasMany(BuildingFloor::class)->orderBy('floor_number');
    }

}