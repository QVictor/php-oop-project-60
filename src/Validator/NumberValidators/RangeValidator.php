<?php

namespace Hexlet\Validator\NumberValidators;

use Hexlet\Validator\ValidatorInterface;

class RangeValidator
{
    public static function getFunction(): \Closure
    {
        return fn($value, $arr) => $value >= $arr['min'] && $value <= $arr['max'];
    }
}
