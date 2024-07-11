<?php

namespace Php\Package\Tests;

use Hexlet\Validator\Validator;
use PHPUnit\Framework\TestCase;

class CustomFunctionValidatorTest extends TestCase
{
    public function testRequiredValidator(): void
    {
        $v = new Validator();

        $fn = fn($value, $start) => str_starts_with($value, $start);

        // Метод добавления новых валидаторов
        $v->addValidator('string', 'startWith', $fn);

        // Новые валидаторы вызываются через метод test
        $schema = $v->string()->test('startWith', 'H');
        $this->assertFalse($schema->isValid('exlet')); // false
        $this->assertTrue($schema->isValid('Hexlet')); // true


        $fn = fn($value, $min) => $value >= $min;
        $v->addValidator('number', 'min', $fn);

        $schema = $v->number()->test('min', 5);
        $this->assertFalse($schema->isValid(4)); // false
        $this->assertTrue($schema->isValid(6)); // true
    }
}
