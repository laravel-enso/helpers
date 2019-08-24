<?php

namespace LaravelEnso\Helpers\app\Traits;

trait DatabaseSeedProgress
{
    private $progressBar;

    public function run()
    {
        $this->command->info('Seeding Database...');

        $this->progressBar = $this->command->getOutput()
            ->createProgressBar(count($this->seeders()));

        $this->progressBar->start();

        collect($this->seeders())->each(function ($seeder) {
            $this->call($seeder, true);

            $this->progressBar->advance();
        });

        $this->progressBar->finish();

        $this->progressBar = null;
    }
}
