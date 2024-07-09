<?php

namespace Hexlet\Validator\NumberValidators;

use Hexlet\Validator\ValidatorInterface;

class RangeValidator
{
    private $min;
    private $max;

    public function __construct($min, $max)
    {
        $this->min = $min;
        $this->max = $max;
    }

    public function isValid($value): bool
    {
        return $value >= $this->min && $value <= $this->max;
    }
}
