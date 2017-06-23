<?php

namespace LaravelEnso\Helpers\Traits;

trait IsActiveTrait
{
    public function scopeActive($query)
    {
        return $query->whereIsActive(true);
    }

    public function scopeDisabled($query)
    {
        return $query->whereIsActive(false);
    }

    public function isActive()
    {
        return (bool) $this->is_active;
    }

    public function isDisabled()
    {
        return !$this->is_active;
    }
}
