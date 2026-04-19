<?php

use LaravelEnso\Helpers\Services\DiskSize;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class DiskSizeTest extends TestCase
{
    #[Test]
    public function formats_bytes_using_the_expected_thresholds()
    {
        $this->assertSame('512.0 B', DiskSize::forHumans('512'));
        $this->assertSame('1.0 KB', DiskSize::forHumans('1024'));
        $this->assertSame('1.5 KB', DiskSize::forHumans('1536'));
        $this->assertSame('1.0 MB', DiskSize::forHumans((string) (1024 ** 2)));
        $this->assertSame('1.0 GB', DiskSize::forHumans((string) (1024 ** 3)));
    }
}
