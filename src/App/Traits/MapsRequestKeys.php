<?php

namespace LaravelEnso\Helpers\App\Traits;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;

trait MapsRequestKeys
{
    public function mapped()
    {
        return (new Collection($this->validated()))
            ->mapWithKeys(fn ($value, $key) => [Str::snake($key) => $value])
            ->toArray();
    }
}
