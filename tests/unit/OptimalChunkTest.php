<?php

use Illuminate\Support\Collection;
use LaravelEnso\Helpers\Services\OptimalChunk;
use Tests\TestCase;

class OptimalChunkTest extends TestCase
{
    private int $limit = 1000000;

    /** @test */
    public function can_get_correct_chunk_within_threshold()
    {
        Collection::wrap(OptimalChunk::Thresholds)
            ->map(fn ($threshold, $index) => $this->map($threshold, $index))
            ->each(fn ($threshold) => $this->assertCorrectChunk($threshold));
    }

    /** @test */
    public function can_get_maximal_chunk_above_threshold()
    {
        $threshold = Collection::wrap(OptimalChunk::Thresholds)->pop();
        $chunk = OptimalChunk::get(++$threshold['limit'], $this->limit);

        $this->assertEquals($chunk, OptimalChunk::MaxChunk);
    }

    private function map(array $threshold, int $index): array
    {
        $start = $index ? OptimalChunk::Thresholds[$index - 1]['limit'] : 0;

        return [
            'min' => $start,
            'max' => $threshold['limit'],
            'chunk' => $threshold['chunk'],
        ];
    }

    private function assertCorrectChunk(array $threshold)
    {
        $count = rand($threshold['min'], $threshold['max']);
        $chunk = OptimalChunk::get($count, $this->limit);

        $this->assertEquals($chunk, $threshold['chunk']);
    }
}
