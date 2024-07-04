<?php

namespace App\Validators;

class RequiredValidator implements ValidatorInterface
{
    public function isValid($value): bool
    {
        return !empty($value);
    }
}