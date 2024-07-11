<?php

namespace Hexlet\Validator;

use Hexlet\Factories\ValidatorFactory;

class RequiredValidator implements ValidatorInterface
{
    public static function getFunction(): \Closure
    {
        return function ($value, $type_validation) {
            switch ($type_validation) {
                case ValidatorFactory::STRING:
                    return !is_null($value) && $value !== '';
                case ValidatorFactory::NUMBER:
                    return is_int(value: $value);
                case ValidatorFactory::ARRAY:
                    return is_array(value: $value);
            }
        };
    }
}
