<?php

namespace Php\Package\Tests;

use App\Validators\Validator;
use PHPUnit\Framework\TestCase;

class RequiredValidatorTest extends TestCase
{
    public function testRequiredValidator(): void
    {
        $v = new Validator();

        $schema = $v->string()->required();
        $this->assertFalse($schema->isValid(null));
        $this->assertFalse($schema->isValid(''));
        $this->assertTrue($schema->isValid('test'));
    }

    public function testRequiredArray()
    {
        $v = new Validator();

        $schema = $v->array();
        $this->assertTrue($schema->isValid(null));

        $schema = $schema->required();

        $this->assertTrue($schema->isValid([]));
        $this->assertTrue($schema->isValid(['hexlet']));
    }
}
