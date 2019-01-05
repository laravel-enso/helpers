<?php

namespace LaravelEnso\Helpers\app\Classes;

use Symfony\Component\Console\Exception\LogicException;

class Obj
{
    public function __construct($arg = null)
    {
        $this->validate($arg);

        foreach ((array) $arg as $key => $value) {
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
        return property_exists($this, $key) && ! is_null($this->$key);
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

    public function isEmpty()
    {
        return empty($this->all());
    }

    public function isNotEmpty()
    {
        return ! $this->isEmpty();
    }

    public function count()
    {
        return count($this->all());
    }

    private function validate($arg)
    {
        if (! is_null($arg)
            && ! is_object($arg)
            && (! is_array($arg)
                || (! empty($arg)
                    && array_keys($arg) === range(0, count($arg) - 1)
        ))) {
            throw new LogicException('If provided, the Obj class constructor must receive an associative array or object');
        }
    }
}
