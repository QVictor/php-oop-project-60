<?php

namespace App\Validators;

use App\Validators\NumberValidators\PositiveValidator;
use App\Validators\NumberValidators\RangeValidator;

class Validator
{
    public array $rules = [];

    public mixed $type_validation;
    public const string TYPE_VALIDATION_STRING = 'string';
    public const string TYPE_VALIDATION_NUMBER = 'number';

//    public const array RULES = [
//        self::REQUIRED => RequiredValidator::class,
//        self::CONTAINS => ContainsValidator::class,
//        self::MIN_LENGTH => MinLengthValidator::class,
//        self::POSITIVE => PositiveValidator::class,
//        self::RANGE => PositiveValidator::class
//    ];
//    public const string REQUIRED = 'required';
//    public const string CONTAINS = 'contains';
//    public const string MIN_LENGTH = 'minLength';
//    public const string POSITIVE = 'positive';
//    public const string RANGE = 'range';

    public function __construct($type_validation = self::TYPE_VALIDATION_STRING)
    {
        $this->type_validation = $type_validation;
    }

    public function string(): static
    {
        return new Validator();
    }

    public function number(): static
    {
        return new Validator(self::TYPE_VALIDATION_NUMBER);
    }

    private function deleteRuleIfExist($className): void
    {
        if (isset($this->rules[$className])) {
            unset($this->rules[$className]);
        }
    }

    public function required(): static
    {
        $className = RequiredValidator::class;
        $this->deleteRuleIfExist($className);
        $this->rules[$className] = new $className();

        return $this;
    }

    public function contains($substring): static
    {
        $className = ContainsValidator::class;
        $this->deleteRuleIfExist($className);
        $this->rules[$className] = new $className($substring);
        return $this;
    }

    public function minLength($minLength): static
    {
        $className = MinLengthValidator::class;
        $this->deleteRuleIfExist($className);
        $this->rules[$className] = new $className($minLength);
        return $this;
    }

    public function isValid($value): bool
    {
        foreach ($this->rules as $rule) {
            if ($rule->isValid($value) === false) {
                return false;
            }
        }
        return true;
    }
}