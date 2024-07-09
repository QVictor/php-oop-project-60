<?php

namespace Hexlet\Validator\ArrayValidators;

use Hexlet\Validator\ValidatorInterface;

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