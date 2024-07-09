<?php

namespace App\Validators;

interface ValidatorInterface
{
    public function isValid(string $value);
}