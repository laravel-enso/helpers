<?php

use Illuminate\Support\Collection;
use LaravelEnso\Helpers\Services\Obj;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ObjTest extends TestCase
{
    #[Test]
    public function wraps_nested_structures_as_obj_instances()
    {
        $obj = new Obj([
            'name' => 'SolarLink',
            'settings' => [
                'theme' => 'light',
                'options' => ['dense' => true],
            ],
            'items' => [1, 2, 3],
        ]);

        $this->assertSame('SolarLink', $obj->get('name'));
        $this->assertInstanceOf(Obj::class, $obj->get('settings'));
        $this->assertSame('light', $obj->get('settings')->get('theme'));
        $this->assertInstanceOf(Obj::class, $obj->get('settings')->get('options'));
        $this->assertTrue($obj->get('settings')->get('options')->get('dense'));
        $this->assertInstanceOf(Obj::class, $obj->get('items'));
        $this->assertSame([1, 2, 3], $obj->get('items')->values()->all());
    }

    #[Test]
    public function set_is_an_alias_for_put()
    {
        $obj = new Obj(['name' => 'SolarLink']);

        $returned = $obj->set('status', 'active');

        $this->assertSame($obj, $returned);
        $this->assertSame('active', $obj->get('status'));
    }

    #[Test]
    public function filled_handles_scalars_arrays_collections_and_nested_objs()
    {
        $obj = new Obj([
            'null' => null,
            'emptyString' => '',
            'emptyArray' => [],
            'emptyCollection' => collect(),
            'nestedEmptyObj' => new Obj(),
            'value' => 'ok',
            'array' => ['x'],
            'collection' => collect(['x']),
            'nestedObj' => new Obj(['x' => 'y']),
        ]);

        $this->assertFalse($obj->filled('null'));
        $this->assertFalse($obj->filled('emptyString'));
        $this->assertFalse($obj->filled('emptyArray'));
        $this->assertFalse($obj->filled('emptyCollection'));
        $this->assertFalse($obj->filled('nestedEmptyObj'));
        $this->assertTrue($obj->filled('value'));
        $this->assertTrue($obj->filled('array'));
        $this->assertTrue($obj->filled('collection'));
        $this->assertTrue($obj->filled('nestedObj'));
    }
}
