<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HotelOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_number',
        'guest_name',
        'items',
        'total_price',
        'status',
    ];
}
