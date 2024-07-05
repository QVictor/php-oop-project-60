<?php

namespace App\Validators\NumberValidators;

use App\Validators\ValidatorInterface;

class PositiveValidator implements ValidatorInterface
{
    public function isValid($value): bool
    {
        return is_null($value) || $value > 0;
    }
}