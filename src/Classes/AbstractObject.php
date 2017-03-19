<?php

namespace LaravelEnso\Helpers\Classes;

abstract class AbstractObject
{
    public function __toString()
    {
        return $this->toJson();
    }

    public function toJson()
    {
        return json_encode($this);
    }

    public function toArray()
    {
        return (array) $this;
    }
}
