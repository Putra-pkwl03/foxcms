<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeMenu extends Model
{
    use HasFactory;

    protected $fillable = [
        'menu_key',
        'menu_name',
        'menu_name_en',
        'icon_path',
        'action_type',
        'action_value',
        'apk_url',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];
}
