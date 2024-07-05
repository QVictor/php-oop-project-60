<?php

namespace App\Validators\ArrayValidators;

use App\Validators\ValidatorInterface;

class SizeOfValidator implements ValidatorInterface
{
    private $arrayLength;

    public function __construct($arrayLength)
    {
        $this->arrayLength = $arrayLength;
    }

    public function isValid($value): bool
    {
        return count($value) === $this->arrayLength;
    }
}