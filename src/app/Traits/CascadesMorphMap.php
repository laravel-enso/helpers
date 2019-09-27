<?php

namespace LaravelEnso\Helpers\app\Traits;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\Relation;

trait CascadesMorphMap
{
    public function getMorphClass()
    {
        $key = Str::camel(Str::singular($this->getTable()));

        return Relation::getMorphedModel($key)
            ? $key
            : parent::getMorphClass();
    }
}
