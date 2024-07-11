<?php

namespace Hexlet\Factories;

use Hexlet\Check;

trait CheckFactory
{
    public function createCheck(object $validationFunction, int|string|array $args = []): Check
    {
        return new Check($validationFunction, $args);
    }
}
