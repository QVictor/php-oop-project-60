<?php

namespace Hexlet\Validator;

use Hexlet\Interfaces\ValidatorInterface;

class MinLengthValidator implements ValidatorInterface
{
    public static function getFunction(): \Closure
    {
        return fn($value, $minLength) => strlen($value) >= $minLength;
    }
}
