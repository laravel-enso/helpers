<?php

namespace LaravelEnso\Helpers\app\Traits;

use Carbon\Carbon;

trait DateAttributes
{
    public function fillDateAttribute($attribute, $value)
    {
        $this->attributes[$attribute] = $value && ! $value instanceof Carbon
            ? Carbon::createFromFormat(
                config('enso.config.dateFormat') ?? $this->getDateFormat(),
                $value
            ) : $value;
    }
}
