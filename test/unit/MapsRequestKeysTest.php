<?php

namespace LaravelEnso\Helpers\App\Exceptions;

use Exception;

class MapsRequestKeysTest extends Exception
{
    public function __construct(string $message, int $code = 555)
    {
        parent::__construct(__($message), $code);
    }

    public function render()
    {
        return response()->json([
            'message' => $this->getMessage(),
        ], $this->getCode());
    }
}
