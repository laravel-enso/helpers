<?php

namespace LaravelEnso\Helpers\Traits;

use Carbon\Carbon;

trait DMYTimestamps
{
	public function getUpdatedAtAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('d-m-Y') : null;
    }

    public function getCreatedAtAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('d-m-Y') : null;
    }
}