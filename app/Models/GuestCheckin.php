<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuestCheckin extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_number',
        'guest_name',
        'checkin_time',
        'checkout_time',
        'status',
    ];
    //
}
