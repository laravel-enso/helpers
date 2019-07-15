<?php

namespace LaravelEnso\Helpers\app\Traits;

trait InCents
{
    //protected $centAttributes = [ ];

    protected $inCents = true;

    public function inCents($mode = true)
    {
        if ($this->inCents === $mode) {
            return false;
        }

        $this->inCents = $mode;

        collect($this->centAttributes)
            ->each(function ($field) {
                $this->attributes[$field] = $this->inCents
                    ? $this->attributes[$field] * 100
                    : $this->attributes[$field] / 100;
            });

        return true;
    }
}
