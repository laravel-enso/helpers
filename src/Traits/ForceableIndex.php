<?php

namespace LaravelEnso\Helpers\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

trait ForceableIndex
{
    public function scopeForceIndex(Builder $query, string $index): Builder
    {
        $query->getQuery()
            ->from(
                DB::raw("{$query->getQuery()->from} FORCE INDEX ({$index})")
            );

        return $query;
    }
}
