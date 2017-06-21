<?php

namespace LaravelEnso\Helpers\Traits;

use Carbon\Carbon;

trait YMDTimestamps
{
	public function getUpdatedAtAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('Y-m-d') : null;
    }

    public function getCreatedAtAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('Y-m-d') : null;
    }
}