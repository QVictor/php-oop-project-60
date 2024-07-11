<?php

namespace Hexlet\Factories;

use Hexlet\Validator\Validator;

trait ValidatorFactory
{
    public function string($validators = []): Validator
    {
        return new Validator(Validator::TYPE_VALIDATION_STRING, $validators);
    }

    public function number($validators = []): Validator
    {
        return new Validator(Validator::TYPE_VALIDATION_NUMBER, $validators);
    }

    public function array($validators = []): Validator
    {
        return new Validator(Validator::TYPE_VALIDATION_ARRAY, $validators);
    }
}
