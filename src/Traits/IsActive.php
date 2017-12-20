<?php

namespace LaravelEnso\Helpers\Traits;

trait IsActive
{
    public function scopeActive($query)
    {
        return $query->whereIsActive(true);
    }

    public function scopeDisabled($query)
    {
        return $query->whereIsActive(false);
    }
}
