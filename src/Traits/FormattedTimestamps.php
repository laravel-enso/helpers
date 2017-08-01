<?php

namespace LaravelEnso\Helpers\Traits;

use Carbon\Carbon;

trait FormattedTimestamps
{
    public function getUpdatedAtAttribute($value)
    {
        return $value
            ? Carbon::parse($value)->format(config('laravel-enso.formattedTimestamps'))
            : null;
    }

    public function getCreatedAtAttribute($value)
    {
        return $value
            ? Carbon::parse($value)->format(config('laravel-enso.formattedTimestamps'))
            : null;
    }
}
