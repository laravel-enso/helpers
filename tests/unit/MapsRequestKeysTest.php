<?php

use LaravelEnso\Helpers\app\Traits\MapsRequestKeys;
use Tests\TestCase;

class MapsRequestKeysTest extends TestCase
{
    use MapsRequestKeys;

    private array $params;

    /** @test */
    public function canMap()
    {
        $this->params = [
            'camelCase' => 'camel_case',
            'underline_case' => 'underline_case',
            'kebab-case' => 'kebab-case',
        ];
        $this->assertEquals([
            'camel_case' => 'camel_case',
            'underline_case' => 'underline_case',
            'kebab-case' => 'kebab-case',
        ], $this->mapped());
    }

    private function validated()
    {
        return $this->params;
    }
}
