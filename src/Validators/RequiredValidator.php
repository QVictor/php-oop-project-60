<?php

namespace App\Validators;

class RequiredValidator implements ValidatorInterface
{
    public function isValid($value, $type = Validator::TYPE_VALIDATION_STRING): bool
    {
        if ($type == Validator::TYPE_VALIDATION_STRING) {
            return !empty($value);
        } else {
            return is_int(value: $value);
        }
    }
}