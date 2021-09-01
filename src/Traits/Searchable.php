<?php

namespace LaravelEnso\Helpers\Traits;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;
use Laravel\Scout\Searchable as ScoutSearchable;
use LaravelEnso\Algolia\Models\Settings;

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
        return App::isProduction()
            && $this::class === App::make($this::class)::class
            && class_exists(Settings::class)
            && Settings::enabled();
    }

    public function shouldPerformSearchSyncing()
    {
        $dirtyKeys = array_keys($this->getDirty());

        return Collection::wrap($this->toSearchableArray())->keys()
            ->map(fn ($key) => Str::snake($key))
            ->intersect($dirtyKeys)->isNotEmpty();
    }
}
