<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemApp extends Model
{
    use HasFactory;

    protected $fillable = [
        'app_key',
        'app_name',
        'app_name_en',
        'icon_path',
        'is_visible',
        'sort_order',
        'android_package',
    ];
}
