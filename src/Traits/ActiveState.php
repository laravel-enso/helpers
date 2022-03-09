<?php

namespace LaravelEnso\Helpers\Traits;

use Illuminate\Database\Eloquent\Builder;

trait ActiveState
{
    public static function bootActiveState()
    {
        self::updating(fn ($model) => $model->fireStateEventIfUpdated());
    }

    public function initializeActiveState()
    {
        if (! in_array('updatedActiveState', $this->observables)) {
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

    public function activate(): void
    {
        $this->update(['is_active' => true]);
    }

    public function deactivate(): void
    {
        $this->update(['is_active' => false]);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where("{$this->getTable()}.is_active", true);
    }

    public function scopeInactive(Builder $query): Builder
    {
        return $query->where("{$this->getTable()}.is_active", false);
    }

    private function fireStateEventIfUpdated(): void
    {
        if ($this->isDirty('is_active')) {
            $this->fireModelEvent('stateUpdated', false);
        }
    }
}
