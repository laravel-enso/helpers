<?php

namespace LaravelEnso\Helpers\Traits;

use Illuminate\Database\Eloquent\Model;
use LogicException;

trait GuardRelationLoad
{
    protected function guardRelationLoad(Model $model, string $relation): mixed
    {
        if (! $model->relationLoaded($relation)) {
            throw new LogicException(sprintf(
                'The [%s] relation must be loaded for [%s]',
                $relation,
                $model::class,
            ));
        }

        return $model->getRelation($relation);
    }
}
