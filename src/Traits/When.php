<?php

namespace LaravelEnso\Helpers\Traits;

use Closure;

trait When
{
    public function when($value, Closure $callback, ?Closure $else = null)
    {
        if ($value) {
            return $callback($this, $value) ?: $this;
        } elseif ($else) {
            return $else($this, $value) ?: $this;
        }

        return $this;
    }
}
