<?php

namespace LaravelEnso\Helpers\Traits;

trait IsActiveTrait
{
    public function scopeActive($query)
    {
        return $query->whereIsActive(1);
    }

    public function scopeDisabled($query)
    {
        return $query->whereIsActive(0);
    }

    public function isActive()
    {
        return $this->is_active == 1;
    }

    public function isDisabled()
    {
        return $this->is_active == 0;
    }
}
