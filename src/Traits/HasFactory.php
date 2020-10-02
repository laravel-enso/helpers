<?php

namespace LaravelEnso\Helpers\Traits;

use Illuminate\Database\Eloquent\Factories\Factory;
use Psy\Util\Str;

trait HasFactory
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;
    
    public static function factory(...$parameters)
    {
        $factory  = static::newFactory() ?: self::packageFactory();

        return $factory
            ->count(is_numeric($parameters[0] ?? null) ? $parameters[0] : null)
            ->state(is_array($parameters[0] ?? null) ? $parameters[0] : ($parameters[1] ?? []));
    }

    private static function packageFactory()
    {
        $factory = Factory::resolveFactoryName(get_called_class());

        if (! class_exists($factory)) {
            Factory::useNamespace(Str::before(self::class, '\\Models'));

            $factory = Factory::resolveFactoryName(get_called_class());
        }

        return $factory::new();
    }
}
