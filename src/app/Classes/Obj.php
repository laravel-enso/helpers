<?php

namespace LaravelEnso\Helpers\app\Classes;

use Illuminate\Support\Collection;

class Obj extends Collection
{
    public function __construct($items = [])
    {
        $this->init($this->getArrayableItems($items));
    }

    public function set($key, $value)
    {
        return $this->put($key, $value);
    }

    public function filled(string $key)
    {
        return ! empty($this->get($key));
    }

    private function init($items)
    {
        foreach ($items as $key => $item) {
            if (! is_scalar($item) && $item !== null) {
                $this->put($key, new self($item));
                continue;
            }

            $this->put($key, $item);
        }
    }
}
