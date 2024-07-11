<?php

namespace Hexlet\Validator;

use Hexlet\Interfaces\ValidatorInterface;

class RequiredValidator implements ValidatorInterface
{
    public static function getFunction(): \Closure
    {
        return function ($value, string $type_validation) {
            switch ($type_validation) {
                case Validator::TYPE_VALIDATION_STRING:
                    return !is_null($value) && $value !== '';
                case Validator::TYPE_VALIDATION_NUMBER:
                    return is_int(value: $value);
                case Validator::TYPE_VALIDATION_ARRAY:
                    return is_array(value: $value);
            }
        };
    }
}
