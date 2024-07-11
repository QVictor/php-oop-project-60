<?php

namespace Hexlet\Factories;

use Hexlet\Validator\Validator;

class ValidatorFactory
{

    public const string STRING = 'string';
    public const string NUMBER = 'number';
    public const string ARRAY = 'array';

    public static function string($validators = []): Validator
    {
        return new Validator(self::STRING, $validators);
    }

    public static function number($validators = []): Validator
    {
        return new Validator(self::NUMBER, $validators);
    }

    public static function array($validators = []): Validator
    {
        return new Validator(self::ARRAY, $validators);
    }
}
