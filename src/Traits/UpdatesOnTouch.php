<?php

namespace LaravelEnso\Helpers\Traits;

use Illuminate\Support\Collection;

trait UpdatesOnTouch
{
    public function touchOwners()
    {
        foreach ($this->touches as $relation) {
            $this->$relation()->touch();

            if ($this->$relation instanceof self) {
                $this->$relation->fireModelEvent('saved', false);
                $this->$relation->fireModelEvent('updated', false);
                $this->$relation->touchOwners();
            } elseif ($this->$relation instanceof Collection) {
                $this->$relation->each->touchOwners();
            }
        }
    }
}
