<?php

namespace LaravelEnso\Helpers\Traits;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;

trait ToSnakeCase
{
    public function prepareForValidation()
    {
        $input = Collection::wrap($this->all())
            ->mapWithKeys(fn ($value, $key) => [Str::snake($key) => $value]);

        $this->replace($input->all());
    }
}
