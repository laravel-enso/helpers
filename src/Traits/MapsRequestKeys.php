<?php

namespace LaravelEnso\Helpers\Traits;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;

trait MapsRequestKeys
{
    public function getValidatorInstance()
    {
        $validator = parent::getValidatorInstance();
        $validator->after(fn () => $this->toSnakeCaseKeys());

        return $validator;
    }

    public function validated($key = null, $default = null)
    {
        return $this->snakeCaseKeys($this->validator->validated());
    }

    private function toSnakeCaseKeys(): void
    {
        $this->replace($this->snakeCaseKeys($this->all()));
    }

    private function snakeCaseKeys(array $request): array
    {
        return Collection::wrap($request)
            ->mapWithKeys(fn ($value, $key) => [Str::snake($key) => $value])
            ->toArray();
    }
}
