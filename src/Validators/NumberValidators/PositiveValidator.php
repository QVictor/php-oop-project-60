<?php

namespace App\Validators\NumberValidators;

use App\Validators\ValidatorInterface;

class PositiveValidator implements ValidatorInterface
{
    public function isValid($value): bool
    {
        return $value > 0;
    }
}