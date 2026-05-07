<?php

namespace LaravelEnso\Helpers\Traits;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;

trait ToSnakeCase
{
    public function prepareForValidation()
    {
        $this->replace($this->snakeKeys($this->all()));
    }

    private function snakeKeys(array $input): array
    {
        return Collection::wrap($input)
            ->mapWithKeys(fn ($value, $key) => [
                is_int($key) ? $key : Str::snake($key) => is_array($value)
                    ? $this->snakeKeys($value)
                    : $value,
            ])->all();
    }
}
