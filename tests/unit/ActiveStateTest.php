<?php

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use PHPUnit\Framework\Attributes\Test;
use LaravelEnso\Helpers\Traits\ActiveState;
use Tests\TestCase;

class ActiveStateTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Schema::dropIfExists('active_state_models');
        Schema::create('active_state_models', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    #[Test]
    public function initializes_the_custom_state_updated_observable()
    {
        $model = new ActiveStateModel();

        $this->assertContains('stateUpdated', $model->getObservableEvents());
    }

    #[Test]
    public function exposes_active_state_helpers_and_scopes()
    {
        $active = ActiveStateModel::create(['name' => 'active', 'is_active' => true]);
        $inactive = ActiveStateModel::create(['name' => 'inactive', 'is_active' => false]);

        $this->assertTrue($active->isActive());
        $this->assertFalse($active->isInactive());
        $this->assertFalse($inactive->isActive());
        $this->assertTrue($inactive->isInactive());
        $this->assertSame([$active->id], ActiveStateModel::query()->active()->pluck('id')->all());
        $this->assertSame([$inactive->id], ActiveStateModel::query()->inactive()->pluck('id')->all());
    }

    #[Test]
    public function can_activate_and_deactivate_models()
    {
        $model = ActiveStateModel::create(['name' => 'toggle', 'is_active' => true]);

        $model->deactivate();
        $this->assertFalse($model->fresh()->is_active);

        $model->fresh()->activate();
        $this->assertTrue($model->fresh()->is_active);
    }

    #[Test]
    public function fires_the_custom_state_updated_event_only_when_the_active_flag_changes()
    {
        $model = ActiveStateModel::create(['name' => 'events', 'is_active' => true]);

        $events = 0;

        ActiveStateModel::registerModelEvent('stateUpdated', function () use (&$events): void {
            $events++;
        });

        $model->update(['name' => 'renamed']);
        $this->assertSame(0, $events);

        $model->update(['is_active' => false]);
        $this->assertSame(1, $events);
    }
}

class ActiveStateModel extends Model
{
    use ActiveState;

    protected $table = 'active_state_models';

    protected $fillable = ['name', 'is_active'];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }
}
