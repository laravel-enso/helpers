<?php

namespace LaravelEnso\Helpers\Traits;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;

trait CascadesMorphMap
{
    protected static array $morphSiblings = [];

    public function getMorphClass()
    {
        return in_array(static::class, self::$morphSiblings)
            ? self::morphMapKey()
            : parent::getMorphClass();
    }

    public static function morphMap()
    {
        Relation::morphMap([
            static::morphMapKey() => get_class(App::make(static::class)),
        ]);

        self::$morphSiblings[] = static::class;
    }

    public static function morphMapKey()
    {
        return Str::camel(Str::singular(static::query()->getModel()->getTable()));
    }
}
