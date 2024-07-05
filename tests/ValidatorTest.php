<?php

namespace Php\Package\Tests;

use App\Validators\Validator;
use PHPUnit\Framework\TestCase;

class ValidatorTest extends TestCase
{
    public function testValidator(): void
    {
        $v = new Validator();

        $schema = $v->string();
        $schema2 = $v->string();

        $this->assertTrue($schema->isValid(''));
        $this->assertTrue($schema->isValid(null));
        $this->assertTrue($schema->isValid('what does the fox say'));

        $schema->required();
        $this->assertTrue($schema2->isValid(''));
        $this->assertFalse($schema->isValid(null));
        $this->assertFalse($schema->isValid(''));

        $this->assertTrue($schema->isValid('hexlet'));
        $this->assertTrue($schema->contains('what')->isValid('what does the fox say'));
        $this->assertFalse($schema->contains('whatthe')->isValid('what does the fox say'));

        $this->assertTrue($v->string()->minLength(10)->minLength(5)->isValid('Hexlet'));
    }

    public function testValidatorPartTwo(): void
    {
        $v = new Validator();

        $schema = $v->number();

        $this->assertTrue($schema->isValid(null));

        $schema->required();

        $this->assertFalse($schema->isValid(null));
        $this->assertTrue($schema->isValid(7));
        $this->assertTrue($schema->positive()->isValid(10));

        $schema->range(-5, 5);

        $this->assertFalse($schema->isValid(-3));
        $this->assertTrue($schema->isValid(5));
    }

    public function testValidatorPartThree(): void
    {
        $v = new Validator();

        $schema = $v->array();
        $this->assertTrue($schema->isValid(null));

        $schema = $schema->required();

        $this->assertTrue($schema->isValid([]));
        $this->assertTrue($schema->isValid(['hexlet']));

        $this->assertTrue((bool)$schema->sizeof(2));

        $this->assertFalse($schema->isValid(['hexlet']));
        $this->assertTrue($schema->isValid(['hexlet', 'code-basics']));
    }
}
