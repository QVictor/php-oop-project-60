<?php

namespace App\Validators;

use App\Validators\ArrayValidators\ShapeValidator;
use App\Validators\ArrayValidators\SizeOfValidator;
use App\Validators\NumberValidators\PositiveValidator;
use App\Validators\NumberValidators\RangeValidator;

class Validator
{
    public array $rules = [];

    public mixed $type_validation;
    public const string TYPE_VALIDATION_STRING = 'string';
    public const string TYPE_VALIDATION_NUMBER = 'number';
    public const string TYPE_VALIDATION_ARRAY = 'array';

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
        return new Validator(self::TYPE_VALIDATION_STRING);
    }

    public function number(): static
    {
        return new Validator(self::TYPE_VALIDATION_NUMBER);
    }

    public function array(): static
    {
        return new Validator(self::TYPE_VALIDATION_ARRAY);
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

    public function positive(): static
    {
        $className = PositiveValidator::class;
        $this->deleteRuleIfExist($className);
        $this->rules[$className] = new $className();
        return $this;
    }

    public function range($min, $max): static
    {
        $className = RangeValidator::class;
        $this->deleteRuleIfExist($className);
        $this->rules[$className] = new $className($min, $max);
        return $this;
    }

    public function sizeof($arrayLength): static
    {
        $className = SizeOfValidator::class;
        $this->deleteRuleIfExist($className);
        $this->rules[$className] = new $className($arrayLength);
        return $this;
    }

    public function shape($arrayWithRules): static
    {
        $className = ShapeValidator::class;
        $this->deleteRuleIfExist($className);
        $this->rules[$className] = new $className($arrayWithRules);
        return $this;
    }

    public function isValid($value): bool
    {
        foreach ($this->rules as $rule) {
            if ($rule->isValid($value, $this->type_validation) === false) {
                return false;
            }
        }
        return true;
    }
}