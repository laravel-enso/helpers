<?php

namespace LaravelEnso\Helpers\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

trait ForceableIndex
{
    public function scopeForceIndex(Builder $query, string $index): Builder
    {
        $raw = DB::raw("{$query->getQuery()->from} FORCE INDEX ({$index})");

        $query->getQuery()->from($raw);

        return $query;
    }

    public function scopeUseIndex(Builder $query, string $index): Builder
    {
        $raw = DB::raw("{$query->getQuery()->from} USE INDEX ({$index})");

        $query->getQuery()->from($raw);

        return $query;
    }
}
