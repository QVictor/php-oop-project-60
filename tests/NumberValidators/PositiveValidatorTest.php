<?php

namespace Php\Package\Tests\NumberValidators;

use Hexlet\Validator\Validator;
use PHPUnit\Framework\TestCase;

class PositiveValidatorTest extends TestCase
{
    public function testPositiveValidator(): void
    {
        $v = new Validator();

        $this->assertTrue($v->number()->required()->positive()->isValid(10));
    }
}
