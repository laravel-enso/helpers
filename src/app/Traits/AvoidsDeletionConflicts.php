<?php

namespace LaravelEnso\Helpers\app\Traits;

use Illuminate\Support\Str;
use Illuminate\Database\QueryException;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

trait AvoidsDeletionConflicts
{
    public function delete()
    {
        try {
            return parent::delete();
        } catch (QueryException $e) {
            $model = str_replace('_', ' ', Str::singular($this->getTable()));

            throw new ConflictHttpException(__(
                'The :model is being used in the system and cannot be deleted',
                ['model' => $model]
            ));
        }
    }
}
