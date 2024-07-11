<?php

namespace Hexlet\Validator\NumberValidators;

class RangeValidator
{
    public static function getFunction(): \Closure
    {
        return fn($value, $arr) => $value >= $arr['min'] && $value <= $arr['max'];
    }
}
