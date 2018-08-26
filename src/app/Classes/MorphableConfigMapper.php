<?php

namespace LaravelEnso\Helpers\app\Classes;

use LaravelEnso\Helpers\app\Exceptions\MorphableConfigException;

abstract class MorphableConfigMapper
{
    protected $configPrefix;
    protected $morphableKey;
    protected $type;
    protected $morphable;

    public function __construct(string $type)
    {
        $this->type = $type;
        $this->morphable = $this->morphable();
    }

    public function class()
    {
        return is_array($this->morphable)
            ? $this->morphable['model']
            : $this->morphable;
    }

    public function model($id)
    {
        return $this->class()::find($id);
    }

    private function morphable()
    {
        $morphable = config($this->configPrefix.'.'.$this->morphableKey.'.'.$this->type);

        if (is_null($morphable)) {
            throw new MorphableConfigException(__(
                'Entity ":entity" does not exist in ":config" config file',
                ['entity' => $this->type, 'config' => $this->configFile()]
            ));
        }

        if (!is_string($morphable) || !class_exists($morphable)) {
            throw new MorphableConfigException(__(
                'Given class for ":entity" in ":config" config file does not exist',
                ['entity' => $this->type, 'config' => $this->configFile()]
            ));
        }

        return $morphable;
    }

    private function configFile()
    {
        return str_replace('.', '/', $this->configPrefix).'.php';
    }
}
