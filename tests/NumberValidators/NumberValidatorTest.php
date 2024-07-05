<?php

namespace Php\Package\Tests\NumberValidators;

use App\Validators\Validator;
use PHPUnit\Framework\TestCase;

class NumberValidatorTest extends TestCase
{
    public function testRequiredValidator(): void
    {
        $v = new Validator();

        $schema = $v->number();

        $this->assertTrue($schema->isValid(null));

        $schema->required();

        $this->assertFalse($schema->isValid(null));
        $this->assertTrue($schema->isValid(7));
    }
}
