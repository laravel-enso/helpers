<?php

namespace LaravelEnso\Helpers\Traits;

use Symfony\Component\Console\Helper\ProgressBar;

trait SeederProgress
{
    private ?ProgressBar $progressBar;
    private int $chunk = 1;

    private function start(int $count)
    {
        $steps = (int) ($count / $this->chunk);

        $this->command->getOutput()->newLine();

        $this->command->warn('Seeding: '.static::class." (chunks of {$this->chunk})");

        $this->progressBar = $this->command->getOutput()
            ->createProgressBar($steps);

        $this->progressBar->start();
    }

    private function advance()
    {
        $this->progressBar->advance();
    }

    private function end()
    {
        $this->progressBar->finish();

        $this->progressBar->clear();

        $this->progressBar = null;

        $this->command->info('Seeded: '.static::class);
    }

    private function chunk(int $chunk)
    {
        $this->chunk = $chunk;

        return $this;
    }

    private function count(int $count)
    {
        $this->count = $count;

        return $this;
    }
}
