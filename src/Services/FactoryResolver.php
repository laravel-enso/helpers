<?php

namespace LaravelEnso\Helpers\Services;

use Illuminate\Support\Str;

class FactoryResolver
{
    private string $model;

    public function __invoke($model)
    {
        $this->model = $model;

        return $this->local() ?? $this->package();
    }

    private function local()
    {
        $baseName = Str::after($this->model, 'Models\\');
        $class = "Database\\Factories\\{$baseName}Factory";

        if (class_exists($class)) {
            return $class;
        }
    }

    private function package()
    {
        $class = $this->class();

        if (class_exists($class)) {
            return $class;
        }
    }

    private function class(): string
    {
        return Str::of($this->model)
            ->replaceFirst('\\Models', '\\Database\\Factories')
            ->append('Factory');
    }
}
