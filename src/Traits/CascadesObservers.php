<?php

namespace LaravelEnso\Helpers\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use ReflectionClass;

trait CascadesObservers
{
    public static function observe($classes)
    {
        $instance = new static;

        foreach (Arr::wrap($classes) as $class) {
            $instance->registerObserver($class);
        }

        $parent = (new ReflectionClass($instance))->getParentClass()->getName();

        if ($parent !== Model::class) {
            $parent::observe($classes);
        }
    }
}
