<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use LaravelEnso\Helpers\Exceptions\InCents as Exception;
use LaravelEnso\Helpers\Traits\InCents;
use Tests\TestCase;

class InCentsTest extends TestCase
{
    private array $params;

    protected function setUp(): void
    {
        parent::setUp();

        $this->createInCentModelTable();
    }

    /** @test */
    public function can_set_incents()
    {
        $model = new InCentModel();
        $model->inCents(true);
        $this->assertTrue($model->inCents);
    }

    /** @test */
    public function cannot_set_incents_with_dirties()
    {
        $this->expectException(Exception::class);

        $model = new InCentModel();
        $model->amount++;
        $model->inCents(true);
    }

    /** @test */
    public function can_change_to_cent()
    {
        $model = new InCentModel();
        $model->inCents(false);
        $model->amount = 1000;
        $model->inCents(true);
        $this->assertEquals(1000 * 100, $model->amount);
    }

    /** @test */
    public function can_change_from_cent()
    {
        $model = new InCentModel();
        $model->inCents(true);
        $model->amount = 1000;
        $model->inCents(false);
        $this->assertEquals(10, $model->amount);
    }

    /** @test */
    public function can_store_cent()
    {
        $model = new InCentModel();
        $model->inCents(false)->fill([
            'amount' => 1000,
        ])->save();

        $this->assertEquals(100000, InCentModel::first()->amount);
    }

    private function createInCentModelTable()
    {
        Schema::create('in_cent_models', function ($table) {
            $table->increments('id');
            $table->integer('amount');
            $table->timestamps();
        });
    }

    private function createModel($normalAmount = null, $centAmount = null)
    {
        $model = (new InCentModel())->inCents(false)->fill([
            'amount' => $centAmount ?? random_int(0, 10000),
        ]);

        $model->save();

        return $model;
    }
}

class InCentModel extends Model
{
    use InCents;

    protected $fillable = ['amount'];
    protected $centAttributes = ['amount'];
}
