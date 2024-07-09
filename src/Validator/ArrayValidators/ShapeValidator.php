<?php

namespace Hexlet\Validator\ArrayValidators;

use Hexlet\Validator\ValidatorInterface;

class ShapeValidator implements ValidatorInterface
{
    private $arrayWithRules;

    public function __construct($arrayWithRules)
    {
        $this->arrayWithRules = $arrayWithRules;
    }

    public function isValid($value): bool
    {
        foreach ($value as $key => $item) {
            if (array_key_exists($key, $this->arrayWithRules)) {
                $validator = $this->arrayWithRules[$key];
                if (!$validator->isValid($item)) {
                    return false;
                }
            }
        }
        return true;
    }
}
