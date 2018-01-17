<?php

namespace LaravelEnso\Helpers\Classes;

class Obj extends AbstractObject
{
    public function __construct(array $properties = [])
    {
        foreach ($properties as $property => $value) {
            $this->$property = $value;
        }
    }
}
