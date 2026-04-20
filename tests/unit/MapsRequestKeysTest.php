<?php

use LaravelEnso\Helpers\Traits\MapsRequestKeys;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class MapsRequestKeysTest extends TestCase
{
    use MapsRequestKeys;

    private TestValidator $validator;

    #[Test]
    public function canMap()
    {
        $this->validator = new TestValidator();

        $this->assertEquals([
            'camel_case'     => 'camel_case',
            'underline_case' => 'underline_case',
            'kebab-case'     => 'kebab-case',
        ], $this->validated());
    }
}

class TestValidator
{
    public function validated()
    {
        return  [
            'camelCase'      => 'camel_case',
            'underline_case' => 'underline_case',
            'kebab-case'     => 'kebab-case',
        ];
    }
}
