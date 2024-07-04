<?php

namespace App\Validators;

use App\Validators\ContainsValidator;

class Validator
{
    public $rules = [];

    public const array RULES = [
        self::REQUIRED => RequiredValidator::class,
        self::CONTAINS => ContainsValidator::class,
        self::MIN_LENGTH => MinLengthValidator::class
    ];
    public const string REQUIRED = 'required';
    public const string CONTAINS = 'contains';
    public const string MIN_LENGTH = 'minLength';

    public function string(): static
    {
        return new Validator();
    }

    private function addRulesIfNecessary($type, $value = false): void
    {
        if (isset($this->rules[$type])) {
            unset($this->rules[$type]);
        }
        $class = self::RULES[$type];
        $this->rules[$type] = new $class($value);
    }

    public function required(): static
    {
        self::addRulesIfNecessary(self::REQUIRED);
        return $this;
    }

    public function contains($substring): static
    {
        self::addRulesIfNecessary(self::CONTAINS, $substring);
        return $this;
    }

    public function minLength($minLength): static
    {
        self::addRulesIfNecessary(self::MIN_LENGTH, $minLength);
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