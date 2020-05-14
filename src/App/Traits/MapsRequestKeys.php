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

    public function withValidator($validator)
    {
        $this->toSnakeCaseKeys($validator);
    }

    public function validated()
    {
        return $this->snakeCaseKeys($this->validator->validated());
    }

    private function toSnakeCaseKeys($validator): void
    {
        $validator->after(fn () => $this->replace($this->snakeCaseKeys($this->all())));
    }

    private function snakeCaseKeys(array $request): array
    {
        return (new Collection($request))
            ->mapWithKeys(fn ($value, $key) => [Str::snake($key) => $value])
            ->toArray();
    }
}
