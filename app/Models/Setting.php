<?php

namespace App\Models;

use App\Enum\SettingType;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['slug', 'key', 'value','setting_type'];
    protected $casts = [
        'setting_type' => SettingType::class,
    ];
}
