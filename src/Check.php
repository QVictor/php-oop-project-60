<?php

namespace Hexlet;

class Check
{
    public $checkFunction;
    public $arg;

    public function __construct($checkFunction, $arg = [])
    {
        $this->checkFunction = $checkFunction;
        $this->arg = $arg;
    }

    public function setArg($arg)
    {
        $this->arg = $arg;
    }

    public function run($value)
    {
        return ($this->checkFunction)($value, $this->arg);
    }
}
