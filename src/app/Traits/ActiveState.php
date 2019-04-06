<?php

namespace LaravelEnso\Helpers\app\Traits;

trait ActiveState
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

    public function activate()
    {
        $this->update(['is_active' => true]);
    }

    public function disable()
    {
        $this->update(['is_active' => false]);
    }
}
