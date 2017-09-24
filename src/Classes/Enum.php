<?php

namespace LaravelEnso\Helpers\Classes;

class Enum extends Object
{
    public function __construct(string $config)
    {
        $this->checkConfig($config);

        parent::__construct(config($config));
    }

    private function checkConfig($config)
    {
        if (config($config) === null || empty(config($config))) {
            throw new \EnsoException('Error processing the enum file: '.$config);
        }
    }
}
