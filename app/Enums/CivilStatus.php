<?php

namespace App\Enums;

enum CivilStatus: string
{
    case SINGLE = 'single';
    case MARRIED = 'married';
    case WIDOWED = 'widowed';
    case DIVORCED = 'divorced';
    case SEPARATED = 'separated';

    public static function values():array
    {
        return array_column(self::cases(), 'value');
    }

    public static function names(): array
    {
        return array_column(self::cases(), 'name');
    }
}
