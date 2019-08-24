<?php

namespace LaravelEnso\Helpers\app\Traits;

trait SeederProgress
{
    private $progressBar;

    public function start(int $count)
    {
        $this->command->getOutput()->newLine();

        $this->command->warn('Seeding '.__CLASS__.'...');

        $this->progressBar = $this->command->getOutput()
            ->createProgressBar($count);

        $this->progressBar->start();
    }

    public function advance()
    {
        $this->progressBar->advance();
    }

    public function finish()
    {
        $this->progressBar->finish();

        $this->progressBar->clear();

        $this->progressBar = null;

        $this->command->info('Seeded '.__CLASS__.'.');

        $this->command->getOutput()->newLine();
    }
}
