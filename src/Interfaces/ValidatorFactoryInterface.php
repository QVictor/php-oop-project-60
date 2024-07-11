<?php

namespace Hexlet\Interfaces;

interface ValidatorFactoryInterface
{
    public static function getFunction(): \Closure;
}
