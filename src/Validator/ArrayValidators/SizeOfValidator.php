<?php

namespace Hexlet\Validator\ArrayValidators;

use Hexlet\Validator\ValidatorInterface;

class SizeOfValidator implements ValidatorInterface
{
    public static function getFunction(): \Closure
    {
        return fn($value, $arrayLength) => count($value) === $arrayLength;
    }
}
