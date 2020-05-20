<?php

namespace LaravelEnso\Helpers\App\Traits;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Collection;

trait TransformMorphMap
{
    public function getValidatorInstance()
    {
        $this->mapMorph();

        return parent::getValidatorInstance();
    }

    protected function mapMorph()
    {
        $model = (new Collection(Relation::$morphMap))
            ->search(fn ($model) => $model === $this->get($this->morphType()))
            ?? $this->get($this->morphType());

        $this->merge([$this->morphType() => $model]);
    }
}
