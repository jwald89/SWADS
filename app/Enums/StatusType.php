<?php

namespace App\Enums;

enum StatusType: string
{
    case PSWDO = 'PSWDO';
    case PGO = 'PGO';
    case PBO = 'PBO';
    case PACO = 'PACO';
    case PTO = 'PTO';
    case CLAIMED = 'CLAIMED';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function names(): array
    {
        return array_column(self::cases(), 'name');
    }
}
