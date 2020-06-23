<?php

namespace LaravelEnso\Helpers\Exceptions;

class JsonParse extends EnsoException
{
    public static function fileNotFound(string $filename)
    {
        return new static(__(
            'Specified file was not found :filename',
            ['filename' => $filename]
        ));
    }

    public static function invalidFile(string $filename)
    {
        return new static(__(
            'File :filename a valid json',
            ['filename' => $filename]
        ));
    }
}
