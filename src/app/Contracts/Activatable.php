<?php

namespace LaravelEnso\Helpers\App\Contracts;

interface Activatable
{
    public function isActive(): bool;

    public function isInactive(): bool;
}
