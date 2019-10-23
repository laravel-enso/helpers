<?php

namespace LaravelEnso\Helpers\app\Traits;

use Carbon\Carbon;
use InvalidArgumentException;

trait DateAttributes
{
    public function fillDateAttribute($attribute, $value, $format = null)
    {
        if (! $value || $value instanceof Carbon) {
            $this->attributes[$attribute] = $value;

            return;
        }

        try {
            $format = $format
                ?? config('enso.config.dateFormat')
                ?? $this->getDateFormat();

            $value = Carbon::createFromFormat($format, $value);
        } catch (InvalidArgumentException $e) {
            $value = Carbon::parse($value);
        } finally {
            $this->attributes[$attribute] = $value;
        }
    }
}
