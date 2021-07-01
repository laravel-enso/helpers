<?php

namespace LaravelEnso\Helpers\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

trait CascadesObservers
{
    public static function observe($classes)
    {
        $instance = new static;

        foreach (Arr::wrap($classes) as $class) {
            $instance->registerObserver($class);
        }

        if (parent::class !== Model::class) {
            parent::observe($classes);
        }
    }
}
