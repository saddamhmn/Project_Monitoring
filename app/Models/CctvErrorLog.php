<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CctvErrorLog extends Model
{
    protected $fillable = [
        'cctv_id', 'user_id', 'technician_name',
        'description', 'photo', 'reported_at',
    ];

    protected $casts = [
        'reported_at' => 'datetime',
    ];

    public function cctv(): BelongsTo
    {
        return $this->belongsTo(Cctv::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}