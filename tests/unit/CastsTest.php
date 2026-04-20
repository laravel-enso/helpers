<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Schema;
use LaravelEnso\Helpers\Casts\Encrypt;
use LaravelEnso\Helpers\Services\Obj as ServiceObj;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CastsTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Schema::dropIfExists('cast_models');
        Schema::create('cast_models', function (Blueprint $table) {
            $table->increments('id');
            $table->text('secret')->nullable();
            $table->text('payload')->nullable();
            $table->timestamps();
        });
    }

    #[Test]
    public function encrypt_cast_round_trips_values_through_eloquent()
    {
        $model = CastModel::create([
            'secret'  => 'top-secret',
            'payload' => ['theme' => 'light'],
        ]);

        $this->assertNotSame('top-secret', $model->getRawOriginal('secret'));
        $this->assertSame('top-secret', $model->fresh()->secret);
        $this->assertSame('top-secret', Crypt::decryptString($model->getRawOriginal('secret')));
    }

    #[Test]
    public function encrypt_cast_returns_null_for_invalid_encrypted_payloads()
    {
        $cast = new Encrypt();

        $this->assertNull($cast->get(new CastModel(), 'secret', 'not-encrypted', []));
        $this->assertNull($cast->set(new CastModel(), 'secret', null, []));
    }

    #[Test]
    public function obj_cast_returns_wrapped_obj_instances_and_serializes_back_to_json()
    {
        $model = CastModel::create([
            'secret'  => 'top-secret',
            'payload' => [
                'theme'    => 'light',
                'settings' => ['dense' => true],
            ],
        ]);

        $fresh = $model->fresh();

        $this->assertInstanceOf(ServiceObj::class, $fresh->payload);
        $this->assertSame('light', $fresh->payload->get('theme'));
        $this->assertInstanceOf(ServiceObj::class, $fresh->payload->get('settings'));
        $this->assertTrue($fresh->payload->get('settings')->get('dense'));
        $this->assertJson($fresh->getRawOriginal('payload'));
        $this->assertSame(
            '{"theme":"light","settings":{"dense":true}}',
            $fresh->getRawOriginal('payload')
        );
    }

    #[Test]
    public function obj_cast_handles_null_values()
    {
        $model = CastModel::create([
            'secret'  => null,
            'payload' => null,
        ]);

        $this->assertNull($model->getRawOriginal('secret'));
        $this->assertNull($model->getRawOriginal('payload'));
        $this->assertInstanceOf(ServiceObj::class, $model->fresh()->payload);
        $this->assertSame([], $model->fresh()->payload->all());
    }
}

class CastModel extends Model
{
    protected $table = 'cast_models';

    protected $fillable = ['secret', 'payload'];

    protected function casts(): array
    {
        return [
            'secret'  => \LaravelEnso\Helpers\Casts\Encrypt::class,
            'payload' => \LaravelEnso\Helpers\Casts\Obj::class,
        ];
    }
}
