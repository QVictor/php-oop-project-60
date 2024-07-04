<?php

namespace App\Validators\NumberValidators;

use App\Validators\ValidatorInterface;

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