<?php

namespace App\Helpers;

class AppHelper
{
    public static function getArrayValue(array $array, string $key, $default = null)
    {
        $value = $array[$key] ?? new NullArray();

        return $value instanceof NullArray ? $default : $value;
    }
}
