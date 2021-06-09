<?php

namespace LaravelEnso\Helpers\Services;

class Dummy
{
    public function __call($name, $arguments): void
    {
    }

    public function __get($name): void
    {
    }

    public function __set($name, $value): void
    {
    }
}
