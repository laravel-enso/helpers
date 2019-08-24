<?php

namespace LaravelEnso\Helpers\app\Traits;

trait DatabaseSeedProgress
{
    public function run()
    {
        $this->command->info('Seeding Database...');

        $this->command->getOutput()->progressStart(count($this->seeders()));

        collect($this->seeders())->each(function ($seeder) {
            $this->call($seeder, true);

            $this->command->getOutput()->progressAdvance();
        });

        $this->command->getOutput()->progressFinish();
    }
}
