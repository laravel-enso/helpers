<?php

namespace LaravelEnso\Helpers\App\Traits;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Str;

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
