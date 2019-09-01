<?php

namespace LaravelEnso\Helpers\app\Traits;

trait SeederProgress
{
    private $progressBar;
    private $chunk;

    private function start(int $count)
    {
        $this->command->getOutput()->newLine();

        $this->command->warn('Seeding: '.__CLASS__." (chunks of {$this->chunk})");

        $this->progressBar = $this->command->getOutput()
            ->createProgressBar($count);

        $this->progressBar->start();
    }

    private function advance()
    {
        $this->progressBar->advance();
    }

    private function finish()
    {
        $this->progressBar->finish();

        $this->progressBar->clear();

        $this->progressBar = null;

        $this->command->info('Seeded: '.__CLASS__);
    }

    private function chunk(int $chunk)
    {
        $this->chunk = $chunk;

        return $this;
    }
}
