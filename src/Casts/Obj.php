<?php

namespace LaravelEnso\Helpers\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use LaravelEnso\Helpers\Services\Obj as Service;

class Obj implements CastsAttributes
{
    public function get($model, string $key, $value, array $attributes)
    {
        return new Service(json_decode($value, true));
    }

    public function set($model, string $key, $value, array $attributes)
    {
        return $value !== null
            ? json_encode($value)
            : null;
    }
}
