<?php

namespace Php\Package\Tests;

use App\Validators\Validator;
use PHPUnit\Framework\TestCase;

class ContainValidatorTest extends TestCase
{
    public function testRequiredValidator(): void
    {
        $v = new Validator();

        $this->assertTrue($v->contains('what')->isValid('what does the fox say'));
        $this->assertFalse($v->contains('whatthe')->isValid('what does the fox say'));
    }
}
