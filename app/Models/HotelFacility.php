<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HotelFacility extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'name_en',
        'icon_path',
        'description',
        'description_en',
        'is_active',
        'show_description',
    ];
}
