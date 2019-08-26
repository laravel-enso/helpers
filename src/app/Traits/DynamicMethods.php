<?php

namespace LaravelEnso\Helpers\app\Traits;

use Closure;
use BadMethodCallException;
use Illuminate\Support\Str;

trait DynamicMethods
{
    protected static $dynamicMethods = [];

    protected static $staticDynamicMethods = [];

    public static function addDynamicMethod($name, Closure $method)
    {
        static::$dynamicMethods[$name] = $method;
    }

    public static function addStaticDynamicMethod($name, Closure $method)
    {
        static::$staticDynamicMethods[$name] = $method;
    }

    public function __call($method, $parameters)
    {
        if (isset(static::$dynamicMethods[$method])) {
            $closure = Closure::bind(static::$dynamicMethods[$method], $this, static::class);

            return call_user_func_array($closure, $parameters);
        }

        if (method_exists($this, '__callAfter')) {
            return $this->__callAfter($method, $parameters);
        }

        if (method_exists(parent::class, '__call')) {
            return parent::__call($method, $parameters);
        }

        throw new BadMethodCallException('Method '.static::class.'::'.$method.'() not found');
    }

    public static function __callStatic($method, $parameters)
    {
        if (isset(static::$staticDynamicMethods[$method])) {
            $closure = Closure::bind(static::$staticDynamicMethods[$method], null, static::class);

            return call_user_func_array($closure, $parameters);
        }

        if (method_exists(static::class, '__callStaticAfter')) {
            return static::__callStaticAfter($method, $parameters);
        }

        if (method_exists(parent::class, '__callStatic')) {
            return parent::__callStatic($method, $parameters);
        }

        throw new BadMethodCallException('Method '.static::class.'::'.$method.'() not found');
    }

    public function getRelationValue($key)
    {
        if ($this->relationLoaded($key)) {
            return $this->relations[$key];
        }

        if (isset(static::$dynamicMethods[$key]) || method_exists($this, $key)) {
            return $this->getRelationshipFromMethod($key);
        }
    }

    public function hasGetMutator($key)
    {
        return isset(static::$dynamicMethods['get'.Str::studly($key).'Attribute'])
            ?: parent::hasGetMutator($key);
    }

    public function hasSetMutator($key)
    {
        return isset(static::$dynamicMethods['set'.Str::studly($key).'Attribute'])
            ?: parent::hasSetMutator($key);
    }
}
