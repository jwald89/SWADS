<?php

namespace App\Enums;

enum UserTypes: string
{
    case IS_SUPERVISOR = 'SUPERVISOR';
    case IS_ADMIN = 'ADMIN';
    case IS_USER = 'USER';
    case IS_MUNICIPAL = 'MUNICIPAL';
    case IS_LIAISON = 'LIAISON';

    public static function values():array
    {
        return array_column(self::cases(), 'value');
    }

    public static function names(): array
    {
        return array_column(self::cases(), 'name');
    }
}
