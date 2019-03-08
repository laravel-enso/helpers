<?php

namespace LaravelEnso\Helpers\app\Classes;

class Obj
{
    public function __construct($arg = [], $root = true)
    {
        $array = json_decode(json_encode($arg), true);
        $this->validate($array, $root);
        $this->toObj($array);
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
        return $this->has($key)
            ? $this->$key
            : null;
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
        return property_exists($this, $key)
            && ! is_null($this->$key)
            && ! empty($this->$key);
    }

    public function forget($keys)
    {
        foreach ((array) $keys as $key) {
            unset($this->$key);
        }
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

    private function toObj($array)
    {
        foreach ($array as $key => $value) {
            if ($this->isValid($key) && ! empty($key)) {
                if (is_array($value) && ! empty($value)) {
                    if ($this->isAssociative($value)) {
                        $this->set($key, new self($value, false));
                        continue;
                    }

                    $this->set($key, $this->mapArray($value));
                    continue;
                }

                $this->set($key, $value);
            }
        }
    }

    private function mapArray($array)
    {
        return array_map(function ($value) {
            return is_array($value) && ! empty($value) && $this->isAssociative($value)
                ? new Obj($value, false)
                : $value;
        }, $array);
    }

    private function validate($arg, $root)
    {
        if (is_null($arg) || $root && ! empty($arg) && ! $this->isAssociative($arg)) {
            throw new \LogicException(
                'If provided, the Obj class constructor must receive an (nested) associative array or object'
            );
        }
    }

    private function isValid($key)
    {
        $valid = preg_match(
            '/^[a-zA-Z_\x7f-\xff-#\/][a-zA-Z0-9_\x7f-\xff-#\/]*$/', $key
        );

        if (! $valid) {
            throw new \LogicException(
                'Key cannot be used as Object property: '.$key
            );
        }

        return $valid;
    }

    private function isAssociative($array)
    {
        return array_keys($array) !== range(0, count($array) - 1);
    }
}
