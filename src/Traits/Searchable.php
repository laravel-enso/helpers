<?php

namespace LaravelEnso\Helpers\Traits;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;
use Laravel\Scout\Searchable as ScoutSearchable;
use LaravelEnso\Algolia\Models\Settings as Algolia;
use LaravelEnso\MeiliSearch\Models\Settings as Meilisearch;

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
            && (class_exists(Algolia::class) && Algolia::enabled()
                || class_exists(Meilisearch::class) && Meilisearch::enabled());
    }

    public function shouldPerformSearchSyncing()
    {
        $dirtyKeys = array_keys($this->getDirty());

        return Collection::wrap($this->toSearchableArray())->keys()
            ->map(fn ($key) => Str::snake($key))
            ->intersect($dirtyKeys)->isNotEmpty();
    }
}
