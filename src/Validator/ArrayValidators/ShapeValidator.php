<?php

namespace Hexlet\Validator\ArrayValidators;

use Hexlet\Interfaces\ValidatorInterface;

class ShapeValidator implements ValidatorInterface
{
    public static function getFunction(): \Closure
    {
        return function ($value, $arrayWithRules) {
            foreach ($value as $key => $item) {
                if (array_key_exists($key, $arrayWithRules)) {
                    $validator = $arrayWithRules[$key];
                    if (!$validator->isValid($item)) {
                        return false;
                    }
                }
            }
            return true;
        };
    }
}
