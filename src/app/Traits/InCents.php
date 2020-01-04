<?php

namespace LaravelEnso\Helpers\App\Traits;

use Illuminate\Support\Collection;
use LaravelEnso\Helpers\App\Classes\Decimals;
use LaravelEnso\Helpers\App\Exceptions\InCents as Exception;

trait InCents
{
    //protected $centAttributes = [ ];

    public ?bool $inCents = null;

    public static function bootInCents()
    {
        self::retrieved(fn ($model) => $model->inCents = true);

        self::saving(fn ($model) => $model->inCents());
    }

    public function inCents(bool $mode = true)
    {
        if ($this->inCents === null) {
            $this->checkCanSetCentMode();
            $this->inCents = $mode;

            return $this;
        }

        if ($this->inCents !== $mode) {
            $this->inCents = $mode;

            (new Collection($this->centAttributes))
                ->filter(fn ($field) => isset($this->attributes[$field]))
                ->each(fn ($field) => $this->updateCentAttribute($field));
        }

        return $this;
    }

    private function updateCentAttribute($field)
    {
        $this->attributes[$field] = $this->inCents
            ? (int) ceil(Decimals::mul($this->attributes[$field], 100))
            : Decimals::div($this->attributes[$field], 100);
    }

    private function checkCanSetCentMode()
    {
        if ((new Collection($this->getDirty()))->keys()
            ->intersect($this->centAttributes)->isNotEmpty()) {
            throw Exception::dirty();
        }
    }
}
