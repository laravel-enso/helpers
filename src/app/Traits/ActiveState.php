<?php

namespace LaravelEnso\Helpers\app\Traits;

trait ActiveState
{
    protected static function bootActiveState()
    {
        self::updating(function ($model) {
            if ($model->isDirty('is_active')) {
                $model->fireModelEvent('updatedActiveState', false);
            }
        });
    }

    protected function initializeActiveState()
    {
        if (! in_array('activation', $this->observables)) {
            $this->observables[] = 'updatedActiveState';
        }
    }

    public function isActive(): bool
    {
        return $this->is_active;
    }

    public function isInactive(): bool
    {
        return ! $this->isActive();
    }

    public function activate()
    {
        $this->update(['is_active' => true]);
    }

    public function deactivate()
    {
        $this->update(['is_active' => false]);
    }

    public function scopeActive($query)
    {
        return $query->whereIsActive(true);
    }

    public function scopeInactive($query)
    {
        return $query->whereIsActive(false);
    }
}
