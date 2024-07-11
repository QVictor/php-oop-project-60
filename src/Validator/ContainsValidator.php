<?php

namespace Hexlet\Validator;

use Hexlet\Interfaces\ValidatorInterface;

class ContainsValidator implements ValidatorInterface
{
    public static function getFunction(): \Closure
    {
        return fn($value, $substring) => str_contains($value, $substring);
    }
}
