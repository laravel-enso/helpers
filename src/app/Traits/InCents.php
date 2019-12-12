<?php

namespace LaravelEnso\Helpers\app\Traits;

use Illuminate\Database\Eloquent\Relations\Pivot;
use LaravelEnso\Helpers\app\Classes\Decimals;
use LogicException;

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
        if ($this->inCents === null && ! $this instanceof Pivot) {
            $this->validate();

            $this->inCents = $mode;

            return $this;
        }

        if ($this->inCents === $mode) {
            return $this;
        }

        $this->inCents = $mode;

        $this->convertCentValues();

        return $this;
    }

    private function validate(): void
    {
        if (collect($this->getDirty())->keys()
            ->intersect($this->centAttributes)->isNotEmpty()) {
            throw new LogicException(
                'Must set cent mode before filling cent attributes'
            );
        }
    }

    private function convertCentValues(): void
    {
        collect($this->centAttributes)
            ->each(function ($field) {
                if (isset($this->attributes[$field])) {
                    $this->attributes[$field] = $this->inCents
                        ? (int) ceil(Decimals::mul($this->attributes[$field], 100))
                        : Decimals::div($this->attributes[$field], 100);
                }
            });
    }
}
