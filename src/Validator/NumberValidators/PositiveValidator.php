<?php

namespace Hexlet\Validator\NumberValidators;

use Hexlet\Validator\ValidatorInterface;

class PositiveValidator implements ValidatorInterface
{
    public function isValid($value): bool
    {
        return is_null($value) || $value > 0;
    }
}