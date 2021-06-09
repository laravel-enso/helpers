<?php

namespace LaravelEnso\Helpers\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use LaravelEnso\Helpers\Services\Obj as Service;

class Obj implements CastsAttributes
{
    public function get($model, string $key, $value, array $attributes)
    {
        return new Service($value);
    }

    public function set($model, string $key, $value, array $attributes)
    {
        return $value;
    }
}
