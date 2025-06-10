<?php

namespace App\Enums;

enum CivilStatus: string
{
    case Single = 'Single';
    case Married = 'Married';
    case Widowed = 'Widowed';
    case Divorced = 'Divorced';
    case Separated = 'Separated';
    case SingleWithCommonLaw = 'Single with common law';

    public static function values():array
    {
        return array_column(self::cases(), 'value');
    }

    public static function names(): array
    {
        return array_column(self::cases(), 'name');
    }
}
