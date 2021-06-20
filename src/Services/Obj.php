<?php

namespace LaravelEnso\Helpers\Services;

use Exception;
use Illuminate\Support\Collection;

class Obj extends Collection
{
    public function __construct($items = [])
    {
        $this->initItems($this->getArrayableItems($items));
    }

    public function set($key, $value): self
    {
        return $this->put($key, $value);
    }

    public function filled(string $key): bool
    {
        if (is_array($this->get($key))) {
            return ! empty($this->get($key));
        }

        if ($this->get($key) instanceof Collection) {
            return $this->get($key)->isNotEmpty();
        }

        return $this->get($key) !== null && $this->get($key) !== '';
    }

    private function initItems(array $items): void
    {
        Collection::wrap($items)
            ->each(fn ($item, $key) => $this->initItem($item, $key));
    }

    private function initItem($item, $key): void
    {
        if (is_scalar($item) || $item === null) {
            $this->put($key, $item);

            return;
        }

        try {
            $this->put($key, new self($item));
        } catch (Exception) {
        }
    }
}
