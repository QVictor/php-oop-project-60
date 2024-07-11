<?php

namespace Hexlet\Factories;

use Hexlet\Validator\Validator;

trait ValidatorFactory
{
    public function string(): Validator
    {
        return new Validator(Validator::TYPE_VALIDATION_STRING, $this->validators);
    }

    public function number(): Validator
    {
        return new Validator(Validator::TYPE_VALIDATION_NUMBER, $this->validators);
    }

    public function array(): Validator
    {
        return new Validator(Validator::TYPE_VALIDATION_ARRAY, $this->validators);
    }
}
