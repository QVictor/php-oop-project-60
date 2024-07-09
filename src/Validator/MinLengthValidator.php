<?php

namespace Hexlet\Validator;

class MinLengthValidator implements ValidatorInterface
{
    private $minLength;

    public function __construct($minLength)
    {
        $this->minLength = $minLength;
    }

    public function isValid($value): bool
    {
        return strlen($value) >= $this->minLength;
    }
}