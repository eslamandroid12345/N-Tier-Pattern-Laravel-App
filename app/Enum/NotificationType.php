<?php

namespace App\Enum;

enum NotificationType: string
{
    case GENERAL = 'general';
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

}
