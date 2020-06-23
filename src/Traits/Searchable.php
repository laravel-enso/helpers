<?php

namespace LaravelEnso\Helpers\Traits;

use Laravel\Scout\Searchable as ScoutSearchable;

trait Searchable
{
    use ScoutSearchable;

    public function save(array $options = [])
    {
        if ($this->shouldPerformSearchSyncing()) {
            return parent::save($options);
        }

        static::disableSearchSyncing();
        $result = parent::save($options);
        static::enableSearchSyncing();

        return $result;
    }

    private function shouldPerformSearchSyncing()
    {
        return ! empty(array_intersect_key($this->getDirty(), $this->toSearchableArray()));
    }
}
