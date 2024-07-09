<?php

namespace Php\Package\Tests\NumberValidators;

use Hexlet\Validator\Validator;
use PHPUnit\Framework\TestCase;

class RangeValidatorTest extends TestCase
{
    public function testValidator(): void
    {
        $v = new Validator();

        $schema = $v->number()->required()->positive()->range(-5, 5);

        $this->assertFalse($schema->isValid(-3));
        $this->assertTrue($schema->isValid(5));
    }
}
