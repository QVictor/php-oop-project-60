<?php

namespace Php\Package\Tests\ArrayValidators;

use App\Validators\Validator;
use PHPUnit\Framework\TestCase;

class SizeOfValidatorTest extends TestCase
{
    public function testValidator(): void
    {
        $v = new Validator();

        $schema = $v->array();

        $schema = $schema->required();

        $this->assertTrue((bool)$schema->sizeof(2));

        $this->assertFalse($schema->isValid(['hexlet']));
        $this->assertTrue($schema->isValid(['hexlet', 'code-basics']));
    }
}
