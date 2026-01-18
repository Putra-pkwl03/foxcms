<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManagedDevice extends Model
{
    use HasFactory;

    protected $fillable = [
        'device_id',
        'device_name',
        'room_number',
        'is_active',
        'last_seen',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'last_seen' => 'datetime',
    ];
}
