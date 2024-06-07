<?php

namespace App\Enums;

enum GenderTypes: string
{
    case Male = 'male';
    case Female = 'female';

    public static function values():array
    {
        return array_column(self::cases(), 'value');
    }

    public static function names(): array
    {
        return array_column(self::cases(), 'name');
    }
}
