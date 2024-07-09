<?php

namespace Hexlet\Validator;

class MinLengthValidator implements ValidatorInterface
{
    public static function getFunction(): \Closure
    {
        return fn($value, $minLength) => strlen($value) >= $minLength;
    }
}
