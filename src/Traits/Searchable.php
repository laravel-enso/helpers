<?php

namespace LaravelEnso\Helpers\Traits;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;
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

    public function shouldPerformSearchSyncing()
    {
        if (! App::isProduction()) {
            return false;
        }

        $dirtyKeys = array_keys($this->getDirty());

        return Collection::wrap($this->toSearchableArray())->keys()
            ->map(fn ($key) => Str::snake($key))
            ->intersect($dirtyKeys)->isNotEmpty();
    }
}
