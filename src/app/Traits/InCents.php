<?php

namespace LaravelEnso\Helpers\App\Traits;

use Illuminate\Support\Collection;
use LaravelEnso\Helpers\App\Classes\Decimals;
use LogicException;

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
        if ($this->inCents === null && $this->hasCleanCentAttributes()) {
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

    private function hasCleanCentAttributes(): bool
    {
        if ((new Collection($this->getDirty()))->keys()
            ->intersect($this->centAttributes)->isNotEmpty()) {
            throw new LogicException(
                'Must set cent mode before filling cent attributes'
            );
        }

        return true;
    }
}
