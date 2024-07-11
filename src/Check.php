<?php

namespace Hexlet;

class Check
{
    public object $checkFunction;
    public mixed $arg;

    public function __construct(object $checkFunction, int|string|array $arg = [])
    {
        $this->checkFunction = $checkFunction;
        $this->arg = $arg;
    }

    public function setArg(int|string $arg): void
    {
        $this->arg = $arg;
    }

    public function run(null|int|string|array $value)
    {
        return ($this->checkFunction)($value, $this->arg);
    }
}
