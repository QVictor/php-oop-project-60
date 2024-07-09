<?php

namespace Hexlet\Validator;

use Hexlet\Validator\ArrayValidators\ShapeValidator;
use Hexlet\Validator\ArrayValidators\SizeOfValidator;
use Hexlet\Validator\NumberValidators\PositiveValidator;
use Hexlet\Validator\NumberValidators\RangeValidator;
use Hexlet\Check;

class Validator
{
    public array $rules = [];
    public array $checks = [];
    public bool $is_require;

    public mixed $type_validation;
    public const string REQUIRED = 'required';
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

    //TODO переписать oldRules!!!
    public function __construct($type_validation = self::TYPE_VALIDATION_STRING, $oldRules = [])
    {
        if ($oldRules != []) {
            $this->rules = $oldRules;
        } else {
            $this->rules = [
                'required' => function ($value, $type_validation) {
                    switch ($type_validation) {
                        case Validator::TYPE_VALIDATION_STRING:
                            return !empty($value);
                        case Validator::TYPE_VALIDATION_NUMBER:
                            return is_int(value: $value);
                        case Validator::TYPE_VALIDATION_ARRAY:
                            return is_array(value: $value);
                    }
                },
                'minLength' => fn($value, $minLength) => strlen($value) >= $minLength,
                'contains' => fn($value, $substring) => str_contains($value, $substring),
                'positive' => fn($value) => is_null($value) || $value > 0,
                'range' => fn($value, $arr) => $value >= $arr['min'] && $value <= $arr['max'],
                'sizeof' => fn($value, $arrayLength) => count($value) === $arrayLength,
                'shape' => function ($value, $arrayWithRules) {
                    foreach ($value as $key => $item) {
                        if (array_key_exists($key, $arrayWithRules)) {
                            $validator = $arrayWithRules[$key];
                            if (!$validator->isValid($item)) {
                                return false;
                            }
                        }
                    }
                    return true;
                }
            ];
        }

        $this->is_require = false;
        $this->type_validation = $type_validation;
    }

    public function string(): static
    {
        return new Validator(self::TYPE_VALIDATION_STRING, $this->rules);
    }

    public function number(): static
    {
        return new Validator(self::TYPE_VALIDATION_NUMBER, $this->rules);
    }

    public function array(): static
    {
        return new Validator(self::TYPE_VALIDATION_ARRAY, $this->rules);
    }

    private function deleteRuleIfExist($className): void
    {
        if (isset($this->rules[$className])) {
            unset($this->rules[$className]);
        }
    }

    public function required(): static
    {
        $this->checks[self::REQUIRED] = new Check($this->rules[self::REQUIRED], $this->type_validation);

        return $this;
    }

    public function contains($substring): static
    {
        $this->checks['contains'] = new Check($this->rules['contains'], $substring);
        return $this;
    }

    public function minLength($minLength): static
    {
        $this->checks['minLength'] = new Check($this->rules['minLength'], $minLength);
        return $this;
    }

    public function positive(): static
    {
        $this->checks['positive'] = new Check($this->rules['positive']);
        return $this;
    }

    public function range($min, $max): static
    {
        $this->checks['range'] = new Check($this->rules['range'], ['min' => $min, 'max' => $max]);
        return $this;
    }

    public function sizeof($arrayLength): static
    {
        $this->checks['sizeof'] = new Check($this->rules['sizeof'], $arrayLength);
        return $this;
    }

    public function shape($arrayWithRules): static
    {
        $this->checks['shape'] = new Check($this->rules['shape'], $arrayWithRules);
        return $this;
    }

    public function addValidator($type, $name, $fn)
    {
        $this->rules[$name] = new Check($fn);
        return $this;
    }

    public function test($checkName, $value)
    {
        if (isset($this->rules[$checkName])) {
            $this->checks[$checkName] = $this->rules[$checkName];
            $this->checks[$checkName]->setArg($value);
        }
        return $this;
    }

    public function isValid($value): bool
    {
        foreach ($this->checks as $nameFunction => $function) {
            if (!$function->run($value)) {
                return false;
            }
        }
        return true;
    }
}
