<?php

namespace LaravelEnso\Helpers\Traits;

use Illuminate\Support\Collection;

/**
 * @deprecated Use Laravel's native $request->safe()->except(...) instead.
 */
trait FiltersRequest
{
    public function validatedExcept($keys): array
    {
        $keys = is_array($keys) ? $keys : func_get_args();

        return Collection::wrap($this->validated())
            ->except($keys)
            ->toArray();
    }
}
