<?php

namespace Hexlet;

class Check
{
    public $validate;
    public $arg;

    public function __construct($validate, $arg = [])
    {
        $this->validate = $validate;
        $this->arg = $arg;
    }

    public function setArg($arg)
    {
        $this->arg = $arg;
    }

    public function run($value)
    {
        return ($this->validate)($value, $this->arg);
    }
}