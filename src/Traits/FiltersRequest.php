<?php

namespace LaravelEnso\Helpers\Traits;

use Illuminate\Support\Collection;

trait FiltersRequest
{
    public function validatedExcept(array $except): array
    {
        return (new Collection($this->validated()))
            ->except($except)
            ->toArray();
    }
}
