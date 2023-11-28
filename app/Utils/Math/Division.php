<?php

namespace App\Utils\Math;

class Division
{
    public static function divisionRoundUp(int $dividend, int $divisor): int
    {
        $result = $dividend / $divisor;
        return ceil($result);
    }
}
