<?php

namespace Php\Package\Tests;

use App\Validators\Validator;
use PHPUnit\Framework\TestCase;

class MinLengthValidatorTest extends TestCase
{
    public function testRequiredValidator(): void
    {
        $v = new Validator();

        $this->assertFalse($v->string()->minLength(5)->isValid('333'));
        $this->assertTrue($v->string()->minLength(5)->isValid('55555'));
    }
}
