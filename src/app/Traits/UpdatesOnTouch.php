<?php

namespace LaravelEnso\Helpers\app\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

trait UpdatesOnTouch
{
    public function touchOwners()
    {
        foreach ($this->touches as $relation) {
            $this->$relation()->touch();

            if ($this->$relation instanceof Model) {
                $this->$relation->fireModelEvent('saved', false);
                $this->$relation->fireModelEvent('updated', false);

                $this->$relation->touchOwners();
            } elseif ($this->$relation instanceof Collection) {
                $this->$relation->each(function (Model $relation) {
                    $relation->touchOwners();
                });
            }
        }
    }
}
