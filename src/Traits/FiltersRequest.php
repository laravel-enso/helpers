<?php

namespace LaravelEnso\Helpers\Traits;

use Illuminate\Support\Collection;

trait FiltersRequest
{
    public function validatedExcept($keys): array
    {
        $keys = is_array($keys) ? $keys : func_get_args();

        return (new Collection($this->validated()))
            ->except($keys)
            ->toArray();
    }
}
