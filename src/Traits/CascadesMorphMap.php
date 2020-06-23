<?php

namespace LaravelEnso\Helpers\Traits;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Str;

trait CascadesMorphMap
{
    public function getMorphClass()
    {
        $key = self::morphMapKey();

        return Relation::getMorphedModel($key)
            ? $key
            : parent::getMorphClass();
    }

    public static function morphMapKey()
    {
        return Str::camel(Str::singular(static::query()->getModel()->getTable()));
    }
}
