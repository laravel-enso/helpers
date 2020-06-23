<?php

use LaravelEnso\Helpers\Traits\MapsRequestKeys;
use Tests\TestCase;

class MapsRequestKeysTest extends TestCase
{
    use MapsRequestKeys;

    private TestValidator $validator;

    /** @test */
    public function canMap()
    {
        $this->validator = new TestValidator();

        $this->assertEquals([
            'camel_case' => 'camel_case',
            'underline_case' => 'underline_case',
            'kebab-case' => 'kebab-case',
        ], $this->validated());
    }
}

class TestValidator
{
    public function validated()
    {
        return  [
            'camelCase' => 'camel_case',
            'underline_case' => 'underline_case',
            'kebab-case' => 'kebab-case',
        ];
    }
}
