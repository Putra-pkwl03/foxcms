<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AmenityRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_number',
        'guest_name',
        'items',
        'status',
    ];
}
