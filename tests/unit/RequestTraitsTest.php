<?php

use Illuminate\Foundation\Http\FormRequest;
use LaravelEnso\Helpers\Traits\FiltersRequest;
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
            'camelCase' => 'camel',
            'kebab-case' => 'kebab',
            'Already_Snake' => 'snake',
        ]);

        $request->prepareForValidation();

        $this->assertSame([
            'camel_case' => 'camel',
            'kebab-case' => 'kebab',
            'already__snake' => 'snake',
        ], $request->all());
    }
}

class FiltersRequestStub
{
    use FiltersRequest;

    public function validated(): array
    {
        return [
            'name' => 'SolarLink',
            'role' => 'admin',
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
