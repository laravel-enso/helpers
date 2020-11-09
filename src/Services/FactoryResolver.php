<?php

namespace LaravelEnso\Helpers\Services;

use Illuminate\Support\Str;

class FactoryResolver
{
    private string $modelName;

    public function __invoke($modelName)
    {
        $this->modelName = $modelName;

        return $this->local() ?? $this->package();
    }

    private function local()
    {
        $model = Str::after($this->modelName, 'Models\\');
        $class = "Database\\Factories\\{$model}Factory";

        if (class_exists($class)) {
            return $class;
        }
    }

    private function package()
    {
        $className = $this->className();

        if (class_exists($className)) {
            return $className;
        }
    }

    private function className(): string
    {
        return Str::of($this->modelName)
            ->replaceFirst('\\Models', '\\Database\\Factories')
            ->append('Factory');
    }
}
