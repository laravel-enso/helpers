<?php

namespace LaravelEnso\Helpers\app\Classes;

class Obj
{
    public function __construct(array $array = [])
    {
        foreach ($array as $key => $value) {
            $this->set($key, $value);
        }
    }

    public function all()
    {
        return get_object_vars($this);
    }

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
        return $this->all();
    }

    public function get(string $key)
    {
        return $this->$key;
    }

    public function set(string $key, $value)
    {
        return $this->$key = $value;
    }

    public function has(string $key)
    {
        return property_exists($this, $key);
    }

    public function filled(string $key)
    {
        return property_exists($this, $key) && !is_null($this->$key);
    }

    public function forget(string $key)
    {
        unset($this->$key);
    }

    public function keys()
    {
        return array_keys($this->all());
    }

    public function values()
    {
        return array_values($this->all());
    }
}
