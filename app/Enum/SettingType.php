<?php

namespace App\Enum;

enum SettingType: string
{
    case GENERAL = 'general';
    case PROCESS = 'process';//This process hidden for front-end

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
