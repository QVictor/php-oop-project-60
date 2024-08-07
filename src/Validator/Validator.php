<?php

namespace Hexlet\Validator;

use Hexlet\Factories\CheckFactory;
use Hexlet\Factories\ValidatorFactory;
use Hexlet\Validator\ArrayValidators\ShapeValidator;
use Hexlet\Validator\ArrayValidators\SizeOfValidator;
use Hexlet\Validator\NumberValidators\PositiveValidator;
use Hexlet\Validator\NumberValidators\RangeValidator;

class Validator
{
    use ValidatorFactory;
    use CheckFactory;

    public array $validators = [];
    public array $checks = [];
    public bool $requiredValue = false;

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

    public string $type_validation;
    public const string TYPE_VALIDATION_STRING = 'string';
    public const string TYPE_VALIDATION_NUMBER = 'number';
    public const string TYPE_VALIDATION_ARRAY = 'array';

    public function __construct(string $type_validation = self::TYPE_VALIDATION_STRING, array $validators = [])
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

    public function required(): static
    {
        $this->requiredValue = true;
        return $this->addToChecks(self::REQUIRED, $this->validators[self::REQUIRED], $this->type_validation);
    }

    public function contains(string $substring): static
    {
        return $this->addToChecks(self::CONTAINS, $this->validators[self::CONTAINS], $substring);
    }

    public function minLength(string $minLength): static
    {
        return $this->addToChecks(self::MIN_LENGTH, $this->validators[self::MIN_LENGTH], $minLength);
    }

    public function positive(): static
    {
        return $this->addToChecks(self::POSITIVE, $this->validators[self::POSITIVE]);
    }

    public function range(int $min, int $max): static
    {
        return $this->addToChecks(self::RANGE, $this->validators[self::RANGE], ['min' => $min, 'max' => $max]);
    }

    public function sizeof(int $arrayLength): static
    {
        return $this->addToChecks(self::SIZE_OF, $this->validators[self::SIZE_OF], $arrayLength);
    }

    public function shape(array $validateRules): static
    {
        return $this->addToChecks(self::SHAPE, $this->validators[self::SHAPE], $validateRules);
    }

    protected function addToChecks(string $validationName, object $validationFunction, int|string|array $args = []): static
    {
        $this->checks[$validationName] = $this->createCheck($validationFunction, $args);
        return $this;
    }

    public function addValidator(string $type, string $name, object $fn): static
    {
        $this->validators[$name] = $this->createCheck($fn);
        return $this;
    }

    public function test(string $customFunctionName, int|string $value): static
    {
        if (isset($this->validators[$customFunctionName])) {
            $this->checks[$customFunctionName] = $this->validators[$customFunctionName];
            $this->checks[$customFunctionName]->setArg($value);
        }
        return $this;
    }

    public function isValid(null|int|string|array $value): bool
    {
        foreach ($this->checks as $function) {
            if (!$function->run($value)) {
                return false;
            }
        }
        return true;
    }
}
