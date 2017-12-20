<?php

namespace LaravelEnso\Helpers\Traits;

trait IsActive
{
    public function isActive()
    {
        return $this->is_active;
    }

    public function isDisabled()
    {
        return ! $this->is_active;
    }

    public function scopeActive($query)
    {
        return $query->whereIsActive(true);
    }

    public function scopeDisabled($query)
    {
        return $query->whereIsActive(false);
    }
}
