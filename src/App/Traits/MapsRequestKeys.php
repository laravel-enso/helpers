<?php

namespace LaravelEnso\Helpers\App\Traits;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;

trait MapsRequestKeys
{
    public function getValidatorInstance()
    {
        $this->toSnakeCaseKeys();

        return parent::getValidatorInstance();
    }

    private function toSnakeCaseKeys(): void
    {
        $this->replace($this->snakeCaseKeys($this->all()));
    }

    private function snakeCaseKeys(array $request): array
    {
        return (new Collection($request))
            ->mapWithKeys(fn ($value, $key) => [Str::snake($key) => $value])
            ->toArray();
    }
}
