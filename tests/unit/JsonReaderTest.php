<?php

use LaravelEnso\Helpers\Exceptions\JsonParse;
use LaravelEnso\Helpers\Services\JsonReader;
use LaravelEnso\Helpers\Services\Obj;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class JsonReaderTest extends TestCase
{
    private string $path;

    protected function setUp(): void
    {
        parent::setUp();

        $this->path = tempnam(sys_get_temp_dir(), 'helpers-json-');

        file_put_contents($this->path, json_encode([
            'name'     => 'SolarLink',
            'settings' => ['theme' => 'light'],
            'items'    => [1, 2, 3],
        ], JSON_THROW_ON_ERROR));
    }

    protected function tearDown(): void
    {
        if (file_exists($this->path)) {
            unlink($this->path);
        }

        parent::tearDown();
    }

    #[Test]
    public function can_read_json_as_an_array()
    {
        $data = (new JsonReader($this->path))->array();

        $this->assertIsArray($data);
        $this->assertSame('SolarLink', $data['name']);
        $this->assertSame('light', $data['settings']['theme']);
    }

    #[Test]
    public function can_read_json_as_a_collection_backed_object()
    {
        $data = (new JsonReader($this->path))->obj();

        $this->assertInstanceOf(Obj::class, $data);
        $this->assertSame('SolarLink', $data->get('name'));
        $this->assertInstanceOf(Obj::class, $data->get('settings'));
        $this->assertSame('light', $data->get('settings')->get('theme'));
    }

    #[Test]
    public function can_read_json_as_a_collection()
    {
        $data = (new JsonReader($this->path))->collection();

        $this->assertSame('SolarLink', $data->get('name'));
        $this->assertSame([1, 2, 3], $data->get('items'));
    }

    #[Test]
    public function can_return_raw_json_content()
    {
        $data = (new JsonReader($this->path))->json();

        $this->assertIsString($data);
        $this->assertStringContainsString('"name":"SolarLink"', $data);
    }

    #[Test]
    public function throws_a_specific_exception_when_the_file_does_not_exist()
    {
        $this->expectException(JsonParse::class);
        $this->expectExceptionMessage('Specified file was not found');

        (new JsonReader($this->path.'-missing'))->array();
    }

    #[Test]
    public function throws_a_specific_exception_when_the_json_is_invalid()
    {
        file_put_contents($this->path, '{"name":');

        $this->expectException(JsonParse::class);
        $this->expectExceptionMessage('a valid json');

        (new JsonReader($this->path))->array();
    }

    #[Test]
    public function throws_for_unknown_output_formats()
    {
        $this->expectException(BadMethodCallException::class);

        (new JsonReader($this->path))->xml();
    }
}
