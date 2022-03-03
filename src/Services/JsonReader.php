<?php

namespace LaravelEnso\Helpers\Services;

use BadMethodCallException;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\File;
use LaravelEnso\Helpers\Exceptions\JsonParse;

class JsonReader
{
    private const Formats = ['object', 'array', 'json', 'collection', 'obj'];

    private string $path;
    private bool $array;
    private bool $json;
    private bool $collection;
    private bool $obj;

    public function __construct(string $path)
    {
        $this->path = $path;
        $this->array = false;
        $this->json = false;
        $this->collection = false;
        $this->obj = false;
    }

    public function __call($method, $args)
    {
        if (in_array($method, self::Formats)) {
            return $this->format($method);
        }

        $class = static::class;

        throw new BadMethodCallException("Method {$class}::{$method}() not found");
    }

    private function format(string $format)
    {
        if ($format !== 'object') {
            $this->enable($format);
        }

        Collection::wrap(self::Formats)
            ->reject(fn ($type) => $type === $format)
            ->each(fn ($format) => $this->disable($format));

        return $this->get();
    }

    private function enable(string $format): void
    {
        $this->{$format} = true;
    }

    private function disable(string $format): void
    {
        $this->{$format} = false;
    }

    private function get()
    {
        $json = $this->content();

        $data = json_decode($json, $this->shouldDecodeToArray());

        $this->validate();

        if ($this->obj) {
            return new Obj($data);
        }

        if ($this->collection) {
            return new Collection($data);
        }

        return $this->json ? $json : $data;
    }

    private function content(): string
    {
        try {
            $json = File::get($this->path);
        } catch (FileNotFoundException) {
            throw JsonParse::fileNotFound($this->path);
        }

        return $json;
    }

    private function shouldDecodeToArray(): bool
    {
        return $this->array || $this->collection || $this->obj;
    }

    private function validate(): void
    {
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw JsonParse::invalidFile($this->path);
        }
    }
}
