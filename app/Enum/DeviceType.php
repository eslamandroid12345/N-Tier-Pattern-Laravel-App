<?php

namespace App\Enum;

enum DeviceType: string
{
    case ANDROID = 'android';
    case IOS = 'ios';
    case HUAWEI = 'huawei';
    case WEBSITE = 'website';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
