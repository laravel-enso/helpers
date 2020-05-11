<?php

namespace LaravelEnso\Helpers\App\Services;

use Illuminate\Support\Facades\Config;

class Sleep
{
    private int $debounce;
    private float $time;

    public function __construct()
    {
        $this->debounce = Config::get('enso.emag.apiDebounce');
        $this->time = $this->now();
    }

    public static function once()
    {
        sleep(Config::get('enso.emag.apiDebounce'));
    }

    public function __invoke()
    {
        $diff = $this->now() - $this->time;

        if ($diff < $this->debounce) {
            sleep($this->debounce - $diff);
        }

        $this->time = $this->now();

        return $this;
    }

    private function now(): int
    {
        return (int) microtime(true);
    }
}
