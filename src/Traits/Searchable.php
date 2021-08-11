<?php

namespace LaravelEnso\Helpers\Traits;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Laravel\Scout\Searchable as ScoutSearchable;
use LaravelEnso\Webshop\Models\Settings;

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

    public function searchIndexShouldBeUpdated()
    {
        return class_exists(Settings::class) && Settings::usesAlgolia();
    }

    public function shouldPerformSearchSyncing()
    {
        $dirtyKeys = array_keys($this->getDirty());

        return Collection::wrap($this->toSearchableArray())->keys()
            ->map(fn ($key) => Str::snake($key))
            ->intersect($dirtyKeys)->isNotEmpty();
    }
}
