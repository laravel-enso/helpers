<?php

namespace LaravelEnso\Helpers\app\Classes;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use LaravelEnso\Helpers\app\Exceptions\JsonParseException;
use LaravelEnso\Helpers\app\Exceptions\FileMissingException;

class JsonParser
{
    private $filename;

    public function __construct(string $filename)
    {
        $this->filename = $filename;
        $this->array = false;
        $this->json = false;
    }

    public function object()
    {
        return $this->get();
    }

    public function array()
    {
        $this->array = true;

        return $this->get();
    }

    public function json()
    {
        $this->json = true;

        return $this->get();
    }

    private function get()
    {
        $json = $this->content();

        $data = $this->array
            ? json_decode($json, true)
            : json_decode($json);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new JsonParseException(__(
                'Json file is not readable :filename',
                ['filename' => $this->filename]
            ));
        }

        return $this->json
            ? $json
            : $data;
    }

    private function content()
    {
        try {
            $json = \File::get($this->filename);
        } catch (FileNotFoundException $e) {
            throw new FileMissingException(__(
                'Specified json file was not found :filename',
                ['filename' => $this->filename]
            ));
        }

        return $json;
    }
}
