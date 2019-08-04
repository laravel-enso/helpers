<?php

namespace LaravelEnso\Helpers\app\Traits;

use Carbon\Carbon;

trait DateAttributes
{
    public function fillDateAttribute($attribute, $value, $format = null)
    {
        $format = $format
            ?? config('enso.config.dateFormat')
            ?? $this->getDateFormat();

        $this->attributes[$attribute] = $value && ! $value instanceof Carbon
            ? Carbon::createFromFormat($format, $value)
            : $value;
    }
}
