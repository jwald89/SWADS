<?php

namespace App\Enums;

enum Month: string
{
    case January = 'jan';
    case February = 'feb';
    case March = 'mar';
    case April = 'apr';
    case May = 'may';
    case June = 'jun';
    case July = 'jul';
    case August = 'aug';
    case September = 'sep';
    case October = 'oct';
    case November = 'nov';
    case December = 'dec';

    public static function values():array
    {
        return array_column(self::cases(), 'value');
    }

    public static function names(): array
    {
        return array_column(self::cases(), 'name');
    }
}
