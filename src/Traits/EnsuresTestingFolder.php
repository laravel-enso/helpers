<?php

namespace LaravelEnso\Helpers\Traits;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

trait EnsuresTestingFolder
{
    protected function ensureTestingFolder(): void
    {
        $folder = Config::get('enso.files.testingFolder');

        if (!$folder) {
            return;
        }

        $path = Storage::path($folder);

        if (!File::isDirectory($path)) {
            File::makeDirectory($path, 0755, true, true);
        }
    }
}
