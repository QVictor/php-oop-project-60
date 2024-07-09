<?php

namespace Php\Package\Tests\ArrayValidators;

use Hexlet\Validator\Validator;
use PHPUnit\Framework\TestCase;

class ShapeValidatorTest extends TestCase
{
    public function testValidator(): void
    {

        $v = new Validator();

        $schema = $v->array();

        // Позволяет описывать валидацию для ключей массива
        $schema->shape([
            'name' => $v->string()->required(),
            'age' => $v->number()->positive(),
        ]);

        $this->assertTrue($schema->isValid(['name' => 'kolya', 'age' => 100]));
        $this->assertTrue($schema->isValid(['name' => 'maya', 'age' => null]));
        $this->assertFalse($schema->isValid(['name' => '', 'age' => null]));
        $this->assertFalse($schema->isValid(['name' => 'ada', 'age' => -5]));
    }
}
