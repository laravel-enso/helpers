<?php

namespace LaravelEnso\Helpers\app\Traits;

use Illuminate\Support\Str;

trait MapsRequestKeys
{
    public function mapped()
    {
        $mapped = [];

        collect($this->validated())
            ->each(function ($value, $key) use (&$mapped) {
                $mapped[Str::snake($key)] = $value;
            });

        return $mapped;
    }
}
