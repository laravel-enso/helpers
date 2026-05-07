<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;
use LaravelEnso\Helpers\Traits\FiltersRequest;
use LaravelEnso\Helpers\Traits\GuardRelationLoad;
use LaravelEnso\Helpers\Traits\ToSnakeCase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class RequestTraitsTest extends TestCase
{
    #[Test]
    public function filters_request_can_exclude_one_or_multiple_keys_from_validated_payload()
    {
        $request = new FiltersRequestStub();

        $this->assertSame(
            ['name' => 'SolarLink', 'email' => 'office@solarlink.test'],
            $request->validatedExcept('role')
        );

        $this->assertSame(
            ['name' => 'SolarLink'],
            $request->validatedExcept('role', 'email')
        );
    }

    #[Test]
    public function to_snake_case_rewrites_input_keys_before_validation()
    {
        $request = ToSnakeCaseRequestStub::create('/', 'POST', [
            'camelCase'     => 'camel',
            'kebab-case'    => 'kebab',
            'Already_Snake' => 'snake',
        ]);

        $request->prepareForValidation();

        $this->assertSame([
            'camel_case'     => 'camel',
            'kebab-case'     => 'kebab',
            'already__snake' => 'snake',
        ], $request->all());
    }

    #[Test]
    public function to_snake_case_recursively_rewrites_nested_input_keys_before_validation()
    {
        $request = ToSnakeCaseRequestStub::create('/', 'POST', [
            'flowPhase' => [
                'statusId' => 1,
                'transitionHandlers' => [
                    ['conditionHandler' => 'Condition'],
                ],
            ],
        ]);

        $request->prepareForValidation();

        $this->assertSame([
            'flow_phase' => [
                'status_id' => 1,
                'transition_handlers' => [
                    ['condition_handler' => 'Condition'],
                ],
            ],
        ], $request->all());
    }

    #[Test]
    public function guard_relation_load_returns_loaded_relation()
    {
        $guard = new GuardRelationLoadStub();
        $model = new RelationLoadModelStub();
        $relation = new RelationLoadModelStub();

        $model->setRelation('flow', $relation);

        $this->assertSame($relation, $guard->relation($model, 'flow'));
    }
}

class FiltersRequestStub
{
    use FiltersRequest;

    public function validated(): array
    {
        return [
            'name'  => 'SolarLink',
            'role'  => 'admin',
            'email' => 'office@solarlink.test',
        ];
    }
}

class ToSnakeCaseRequestStub extends FormRequest
{
    use ToSnakeCase;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [];
    }
}

class GuardRelationLoadStub
{
    use GuardRelationLoad;

    public function relation(Model $model, string $relation): mixed
    {
        return $this->guardRelationLoad($model, $relation);
    }
}

class RelationLoadModelStub extends Model
{
}
