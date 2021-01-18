<?php

namespace LaravelEnso\Helpers\Services;

class Dummy
{
    public function __call($name, $arguments)
    {
        return null;
    }

    public function __get($name)
    {
        return null;
    }

    public function __set($name, $value)
    {
        return null;
    }
}
