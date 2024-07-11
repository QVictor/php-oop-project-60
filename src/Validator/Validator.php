<?php

namespace Hexlet\Validator;

use Hexlet\Validator\ArrayValidators\ShapeValidator;
use Hexlet\Validator\ArrayValidators\SizeOfValidator;
use Hexlet\Validator\NumberValidators\PositiveValidator;
use Hexlet\Validator\NumberValidators\RangeValidator;
use Hexlet\Check;

class Validator
{
    public array $validators = [];
    public array $checks = [];
    public bool $requiredValue = false;

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
            $this->validators = $oldRules;
        } else {
            $this->validators = [
                'required' => RequiredValidator::getFunction(),
                'minLength' => MinLengthValidator::getFunction(),
                'contains' => ContainsValidator::getFunction(),
                'positive' => PositiveValidator::getFunction(),
                'range' => RangeValidator::getFunction(),
                'sizeof' => SizeOfValidator::getFunction(),
                'shape' => ShapeValidator::getFunction()
            ];
        }

        $this->type_validation = $type_validation;
    }

    public function string(): static
    {
        return new Validator(self::TYPE_VALIDATION_STRING, $this->validators);
    }

    public function number(): static
    {
        return new Validator(self::TYPE_VALIDATION_NUMBER, $this->validators);
    }

    public function array(): static
    {
        return new Validator(self::TYPE_VALIDATION_ARRAY, $this->validators);
    }

    private function deleteRuleIfExist($className): void
    {
        if (isset($this->validators[$className])) {
            unset($this->validators[$className]);
        }
    }

    //TODO вынести Checks в отдельный класс (фабрика?)
    public function required(): static
    {
        $this->checks[self::REQUIRED] = new Check($this->validators[self::REQUIRED], $this->type_validation);
        $this->requiredValue = true;

        return $this;
    }

    public function contains($substring): static
    {
        $this->checks['contains'] = new Check($this->validators['contains'], $substring);
        return $this;
    }

    public function minLength($minLength): static
    {
        $this->checks['minLength'] = new Check($this->validators['minLength'], $minLength);
        return $this;
    }

    public function positive(): static
    {
        $this->checks['positive'] = new Check($this->validators['positive']);
        return $this;
    }

    public function range($min, $max): static
    {
        $this->checks['range'] = new Check($this->validators['range'], ['min' => $min, 'max' => $max]);
        return $this;
    }

    public function sizeof($arrayLength): static
    {
        $this->checks['sizeof'] = new Check($this->validators['sizeof'], $arrayLength);
        return $this;
    }

    public function shape($arrayWithRules): static
    {
        $this->checks['shape'] = new Check($this->validators['shape'], $arrayWithRules);
        return $this;
    }

    public function addValidator($type, $name, $fn)
    {
        $this->validators[$name] = new Check($fn);
        return $this;
    }

    public function test($userFunctionName, $value)
    {
        if (isset($this->validators[$userFunctionName])) {
            $this->checks[$userFunctionName] = $this->validators[$userFunctionName];
            $this->checks[$userFunctionName]->setArg($value);
        }
        return $this;
    }

    public function isValid($value): bool
    {
        foreach ($this->checks as $function) {
            if (!$function->run($value)) {
                return false;
            }
        }
        return true;
    }
}
