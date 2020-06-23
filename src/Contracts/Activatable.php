<?php

namespace LaravelEnso\Helpers\Contracts;

interface Activatable
{
    public function isActive(): bool;

    public function isInactive(): bool;
}
