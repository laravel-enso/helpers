<?php

namespace LaravelEnso\Helpers\Services;

use Illuminate\Support\Collection;

class OptimalChunk
{
    public const Thresholds = [
        ['limit' => 1000, 'chunk' => 100],
        ['limit' => 10 * 1000, 'chunk' => 250],
        ['limit' => 50 * 1000, 'chunk' => 2 * 500],
        ['limit' => 250 * 1000, 'chunk' => 4 * 500],
        ['limit' => 1000 * 1000, 'chunk' => 10 * 500],
    ];

    public const MaxChunk = 10000;

    public static function get(int $count, int $min = 1000000): int
    {
        $match = (new Collection(self::Thresholds))
            ->first(fn ($threshold) => $count <= $threshold['limit']);

        $limit = $match ? $match['chunk'] : self::MaxChunk;

        return min($limit, $min);
    }
}
