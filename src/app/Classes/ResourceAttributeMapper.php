<?php

namespace LaravelEnso\Helpers\app\Classes;

use Illuminate\Http\Resources\Json\JsonResource;

class ResourceAttributeMapper
{
    private $model;
    private $attributes;

    public function __construct(JsonResource $model, array $attributes)
    {
        $this->model = $model;
        $this->attributes = $attributes;
    }

    public function get()
    {
        $attrs = [];

        collect($this->attributes)
            ->each(function ($value, $key) use (&$attrs) {
                $attrs[$key] = $this->model->{$value};
            });

        return $attrs;
    }
}
