<?php

namespace Hexlet\Validator;

class RequiredValidator implements ValidatorInterface
{
    public static function getFunction(): \Closure
    {
        return function ($value, $type_validation) {
            switch ($type_validation) {
                case Validator::TYPE_VALIDATION_STRING:
                    return !empty($value);
                case Validator::TYPE_VALIDATION_NUMBER:
                    return is_int(value: $value);
                case Validator::TYPE_VALIDATION_ARRAY:
                    return is_array(value: $value);
            }
        };
    }
}
