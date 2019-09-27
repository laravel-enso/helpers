<?php

namespace LaravelEnso\Helpers\app\Traits;

trait CascadesMorphMap
{
    public function getMorphClass()
    {
        $key = Str::singular($this->getTable());

        return Relation::getMorphedModel($key)
            ? $key
            : parent::getMorphClass();
    }
}
