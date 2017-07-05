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

    public function get(string $key)
    {
        return $this->$key;
    }

    public function has(string $key)
    {
        return property_exists($this, $key);
    }

    public function getProperties()
    {
        return array_keys(get_object_vars($this));
    }
}
