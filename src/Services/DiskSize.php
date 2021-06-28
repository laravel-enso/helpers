<?php

namespace LaravelEnso\Helpers\Services;

class DiskSize
{
    public static function forHumans(string $bytes): string
    {
        $threshholds = ['B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
        $base = 1024;
        $threshold = min((int) log($bytes, $base), count($threshholds) - 1);
        $size = Decimals::div($bytes, Decimals::pow($base, $threshold));

        return "{$size} {$threshholds[$threshold]}";
    }
}
