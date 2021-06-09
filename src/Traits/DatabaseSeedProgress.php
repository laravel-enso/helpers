<?php

namespace LaravelEnso\Helpers\Traits;

use Illuminate\Support\Collection;
use Symfony\Component\Console\Helper\ProgressBar;

trait DatabaseSeedProgress
{
    private ?ProgressBar $progressBar;

    public function run()
    {
        $this->command->info('Seeding Database...');

        $this->progressBar = $this->command->getOutput()
            ->createProgressBar(count($this->seeders()));

        $this->progressBar->start();

        Collection::wrap($this->seeders())
            ->each(fn ($seeder) => $this->callSeedr($seeder));

        $this->progressBar->finish();

        $this->progressBar = null;
    }

    private function callSeeder($seeder)
    {
        $this->call($seeder, true);

        $this->progressBar->advance();
    }
}
