<?php

namespace Hexlet\Validator;

class RequiredValidator implements ValidatorInterface
{
    public function isValid($value, $type = Validator::TYPE_VALIDATION_STRING): bool
    {
        switch ($type) {
            case Validator::TYPE_VALIDATION_STRING:
                return !empty($value);
            case Validator::TYPE_VALIDATION_NUMBER:
                return is_int(value: $value);
            case Validator::TYPE_VALIDATION_ARRAY:
                return is_array(value: $value);
        }
        return false;
    }
}
