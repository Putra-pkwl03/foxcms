<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManagedDevice extends Model
{
    use HasFactory;

    protected $fillable = [
        'device_id',
        'registration_code',
        'device_name',
        'room_number',
        'is_active',
        'last_seen',
        'ip_address',
        'status_online',
        'notes',
        'registered_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'last_seen' => 'datetime',
        'registered_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->registration_code) {
                do {
                    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                    $code = 'TV-';
                    for ($i = 0; $i < 6; $i++) {
                        $code .= $characters[rand(0, strlen($characters) - 1)];
                    }
                } while (static::where('registration_code', $code)->exists());
                $model->registration_code = $code;
            }
        });
    }
}
