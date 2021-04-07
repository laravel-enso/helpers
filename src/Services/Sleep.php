<?php

namespace LaravelEnso\Helpers\Services;

class Sleep
{
    private int $debounce;
    private float $time;

    public function __construct(int $debounce)
    {
        $this->debounce = $debounce;
        $this->time = $this->now();
    }

    public static function once()
    {
        sleep($this->debounce);
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
