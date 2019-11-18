<?php

namespace LaravelEnso\Helpers\app\Classes;

use Exception;
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
        if (is_array($this->get($key))) {
            return ! empty($this->get($key));
        }

        if ($this->get($key) instanceof Collection) {
            return $this->get($key)->isNotEmpty();
        }

        return $this->get($key) !== null && $this->get($key) !== '';
    }

    private function init($items)
    {
        foreach ($items as $key => $item) {
            if (! is_scalar($item) && $item !== null) {
                try {
                    $this->put($key, new self($item));
                    continue;
                } catch (Exception $e) {
                }
            }

            $this->put($key, $item);
        }
    }
}
