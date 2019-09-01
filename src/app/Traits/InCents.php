<?php

namespace LaravelEnso\Helpers\app\Traits;

use LogicException;
use LaravelEnso\Helpers\app\Classes\Decimals;

trait InCents
{
    //protected $centAttributes = [ ];

    public $inCents = null;

    public static function bootInCents()
    {
        self::retrieved(function ($model) {
            $model->inCents = true;
        });

        self::saving(function ($model) {
            $model->inCents();
        });
    }

    public function inCents(bool $mode = true)
    {
        if ($this->inCents === null) {
            if (collect($this->getDirty())->intersect($this->centAttributes)->isNotEmpty()) {
                throw new LogicException(
                    'Must set cent mode before filling cent attributes'
                );
            }

            $this->inCents = $mode;

            return $this;
        }

        if ($this->inCents === $mode) {
            return $this;
        }

        $this->inCents = $mode;

        collect($this->centAttributes)
            ->each(function ($field) {
                $this->attributes[$field] = $this->inCents
                    ? (int) ceil(Decimals::mul($this->attributes[$field], 100))
                    : Decimals::div($this->attributes[$field], 100);
            });

        return $this;
    }
}
