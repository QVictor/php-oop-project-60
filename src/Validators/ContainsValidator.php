<?php

namespace App\Validators;

class ContainsValidator implements ValidatorInterface
{
    private $substring;

    public function __construct($substring)
    {
        $this->substring = $substring;
    }

    public function isValid($value): bool
    {
        return str_contains($value, $this->substring);
    }
}