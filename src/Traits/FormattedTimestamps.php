<?php

namespace LaravelEnso\Helpers\Traits;

use Carbon\Carbon;

trait FormattedTimestamps
{
    public function getUpdatedAtAttribute($value)
    {
        return $value
            ? Carbon::parse($value)->format(config('enso.config.phpDateFormat'))
            : null;
    }

    public function getCreatedAtAttribute($value)
    {
        return $value
            ? Carbon::parse($value)->format(config('enso.config.phpDateFormat'))
            : null;
    }
}
