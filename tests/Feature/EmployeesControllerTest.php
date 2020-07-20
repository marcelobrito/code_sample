<?php

namespace Tests\Feature;

use App\Repositories\EmployeeRepository;
use Tests\TestCase;
use App\Entities\Employee;
use App\Models\Employee as ModelEmployee;

class EmployeesControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware();
    }
    /**
     * @test
     */
    public function itShouldValidateFields()
    {
        $response = $this->json('POST', '/api/v1/employees');
        $response->assertJsonValidationErrors([
            'name' => 'The name field is required.',
            'email' => 'The email field is required.',
        ]);
    }

    /**
     * @test
     */
    public function itShouldValidateEmail()
    {

        $response = $this->json('POST', '/api/v1/employees', [
            'name' => 'marcelo',
            'email' => 'invalid_email'
        ]);
        $response->assertJsonValidationErrors([
            'email' => 'The email must be a valid email address.',
        ]);
    }

    /**
     * @test
     */
    public function itShouldReturnEmployee()
    {
        $model = factory(ModelEmployee::class)->create();
        $response = $this->json('GET', '/api/v1/employees/'.$model->id);
        $response->assertStatus(200);
        $response->assertJson($model->toArray());
    }

    /**
     * @test
     */
    public function itShouldReturnEmployees()
    {
        $employees = factory(ModelEmployee::class, 2)->create();
        $response = $this->json('GET', '/api/v1/employees');
        $response->assertStatus(200);

        $response->assertJsonCount(2);
        $response->assertJson([
            $employees->first()->toArray(),
            $employees->get(1)->toArray()
        ]);
    }

    /**
     * @test
     */
    public function itShouldCreateEmployee()
    {
        $model = factory(ModelEmployee::class)->make();

        $response = $this->json('POST', '/api/v1/employees', $model->toArray());
        $response->assertStatus(201);
        $response->assertJson($model->toArray());

        $this->assertDatabaseHas('employees',$model->toArray());
        $this->assertDatabaseCount('employees',1);
    }

    /**
     * @test
     */
    public function itShouldValidateEditEmployee()
    {

        $firstEmployee = factory(ModelEmployee::class)->create();
        $employee = factory(ModelEmployee::class)->create();
        $employee->name = 'new name';
        $employee->email = $firstEmployee->email;
        $response = $this->json('PUT', '/api/v1/employees/123123123', $employee->getAttributes());
        $response->assertJsonValidationErrors([
            'id' => 'The selected id is invalid.',
            'email' => 'The email has already been taken.',
        ]);
    }

    /**
     * @test
     */
    public function itShouldEditEmployee()
    {
        $employee = factory(ModelEmployee::class)->create();
        $employee->name = 'new name';
        $employee->email = 'newEmail@email.com';
        $response = $this->json('PUT', '/api/v1/employees/'.$employee->id, $employee->getAttributes());
        $response->assertStatus(200);
        $response->assertJson($employee->toArray());

        $this->assertDatabaseHas('employees',$employee->toArray());
        $this->assertDatabaseCount('employees',1);
    }


    /**
     * @test
     */
    public function itShouldValidateDeleteEmployee()
    {
        $response = $this->json('DELETE', '/api/v1/employees/123123');
        $response->assertJsonValidationErrors([
            'id' => 'The selected id is invalid.'
        ]);
    }

    /**
     * @test
     */
    public function itShouldDeleteEmployee()
    {
        $employee = factory(ModelEmployee::class)->create();
        $this->assertDatabaseCount('employees',1);

        $response = $this->json('DELETE', '/api/v1/employees/'.$employee->id);
        
        $response->assertStatus(200);

        $this->assertDatabaseCount('employees',0);
    }
}
