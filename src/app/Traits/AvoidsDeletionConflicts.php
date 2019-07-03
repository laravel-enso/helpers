<?php

namespace LaravelEnso\Helpers\app\Traits;

use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

trait AvoidsDeletionConflicts
{
    public function delete()
    {
        try {
            parent::delete();
        } catch (\Exception $e) {
            $model = str_replace('_', ' ', Str::singular($this->getTable()));

            throw new ConflictHttpException(__(
                'The :model is being used in the system and cannot be deleted',
                ['model' => $model]
            ));
        }
    }
}
