<?php

namespace LaravelEnso\Helpers\app\Traits;

use Illuminate\Support\Str;

trait MapsRequestKeys
{
    public function mapped()
    {
        return collect($this->validated())
            ->mapWithKeys(fn ($value, $key) => [Str::snake($key) => $value])
            ->toArray();
    }
}
