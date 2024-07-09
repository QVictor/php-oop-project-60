<?php

namespace Hexlet\Validator\NumberValidators;

use Hexlet\Validator\ValidatorInterface;

class PositiveValidator implements ValidatorInterface
{
    public static function getFunction(): \Closure
    {
        return fn($value) => is_null($value) || $value > 0;
    }
}
