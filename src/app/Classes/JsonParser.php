<?php

namespace LaravelEnso\Helpers\App\Classes;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\File;
use LaravelEnso\Helpers\App\Exceptions\JsonParse;

class JsonParser
{
    private string $filename;
    private bool $array;
    private bool $json;

    public function __construct(string $filename)
    {
        $this->filename = $filename;
        $this->array = false;
        $this->json = false;
    }

    public function object()
    {
        $this->array = false;
        $this->json = false;

        return $this->get();
    }

    public function array()
    {
        $this->array = true;
        $this->json = false;

        return $this->get();
    }

    public function json()
    {
        $this->json = true;
        $this->array = false;

        return $this->get();
    }

    private function get()
    {
        $json = $this->content();

        $data = json_decode($json, $this->array);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw JsonParse::invalidFile($this->filename);
        }

        return $this->json ? $json : $data;
    }

    private function content(): string
    {
        try {
            $json = File::get($this->filename);
        } catch (FileNotFoundException $exception) {
            throw JsonParse::fileNotFound($this->filename);
        }

        return $json;
    }
}
