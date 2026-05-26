<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CctvMaintenanceLog extends Model
{
    protected $fillable = [
        'cctv_id', 'user_id', 'technician_name',
        'note', 'photo', 'performed_at',
    ];

    protected $casts = [
        'performed_at' => 'datetime',
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