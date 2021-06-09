<?php

namespace LaravelEnso\Helpers\Traits;

use Illuminate\Support\Collection;
use LaravelEnso\Helpers\Exceptions\InCents as Exception;
use LaravelEnso\Helpers\Services\Decimals;

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
        if ($this->inCents === null && $this->centAttributesAreClean()) {
            $this->inCents = $mode;

            return $this;
        }

        if ($this->inCents !== $mode) {
            $this->inCents = $mode;
            $this->updateCentAttributes();
        }

        return $this;
    }

    private function updateCentAttributes()
    {
        Collection::wrap($this->centAttributes)
            ->filter(fn ($field) => isset($this->attributes[$field]))
            ->each(fn ($field) => $this->updateCentAttribute($field));
    }

    private function updateCentAttribute($field)
    {
        $this->attributes[$field] = $this->inCents
            ? (int) ceil(Decimals::mul($this->attributes[$field], 100))
            : Decimals::div($this->attributes[$field], 100);
    }

    private function centAttributesAreClean(): bool
    {
        $dirty = Collection::wrap($this->getDirty())->keys()
            ->intersect($this->centAttributes)->isNotEmpty();

        if ($dirty) {
            throw Exception::dirty();
        }

        return true;
    }
}
