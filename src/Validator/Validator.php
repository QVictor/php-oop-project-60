<?php

namespace Hexlet\Validator;

use Hexlet\Factories\ValidatorFactory;
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

    public const array VALIDATORS_CLASSES = [
        self::REQUIRED => RequiredValidator::class,
        self::CONTAINS => ContainsValidator::class,
        self::MIN_LENGTH => MinLengthValidator::class,
        self::POSITIVE => PositiveValidator::class,
        self::RANGE => RangeValidator::class,
        self::SIZE_OF => SizeOfValidator::class,
        self::SHAPE => ShapeValidator::class,
    ];

    public const string REQUIRED = 'required';
    public const string CONTAINS = 'contains';
    public const string MIN_LENGTH = 'minLength';
    public const string POSITIVE = 'positive';
    public const string RANGE = 'range';
    public const string SIZE_OF = 'sizeof';
    public const string SHAPE = 'shape';

    //TODO переписать oldRules!!!
    public function __construct($type_validation = ValidatorFactory::STRING, $validators = [])
    {
        if ($validators != []) {
            $this->validators = $validators;
        } else {
            $this->setValidatorsDefault();
        }

        $this->type_validation = $type_validation;
    }

    public function setValidatorsDefault(): void
    {
        foreach (self::VALIDATORS_CLASSES as $validatorName => $validatorClass) {
            $this->validators[$validatorName] = $validatorClass::getFunction();
        }
    }

    public function string(): static
    {
        return ValidatorFactory::string($this->validators);
//        return new Validator(self::TYPE_VALIDATION_STRING, $this->validators);
    }

    public function number(): static
    {
        return ValidatorFactory::number($this->validators);
    }

    public function array(): static
    {
        return ValidatorFactory::array($this->validators);
    }

    public function required(): static
    {
        $this->requiredValue = true;
        return $this->addToChecks(self::REQUIRED,$this->validators[self::REQUIRED], $this->type_validation);
    }

    public function contains($substring): static
    {
        return $this->addToChecks(self::CONTAINS,$this->validators[self::CONTAINS], $substring);
    }

    public function minLength($minLength): static
    {
        return $this->addToChecks(self::MIN_LENGTH,$this->validators[self::MIN_LENGTH], $minLength);
    }

    public function positive(): static
    {
        return $this->addToChecks(self::POSITIVE,$this->validators[self::POSITIVE]);
    }

    public function range($min, $max): static
    {
        return $this->addToChecks(self::RANGE,$this->validators[self::RANGE],['min' => $min, 'max' => $max]);
    }

    public function sizeof($arrayLength): static
    {
        return $this->addToChecks(self::SIZE_OF,$this->validators[self::SIZE_OF],$arrayLength);
    }

    public function shape($arrayWithRules): static
    {
        return $this->addToChecks(self::SHAPE,$this->validators[self::SHAPE],$arrayWithRules);
    }

    protected function addToChecks($validationName, $validationFunction, $args = []): static
    {
        $this->checks[$validationName] = $this->checkFactory($validationFunction, $args);
        return $this;
    }

    protected function checkFactory($validationFunction, $args = []): Check
    {
        return new Check($validationFunction, $args);
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
