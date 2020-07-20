<?php

namespace Tests\Feature;

use App\Models\Employee as ModelEmployee;
use App\Repositories\EmployeeRepository;
use Tests\TestCase;
use RuntimeException;
use Mockery;

class EmployeesWithMockControllerTest extends TestCase
{
    /** @test */
    public function itShouldMockCreate()
    {
        $this->withoutMiddleware();
        // Mocking the EmployeeRepository
        $employeeRepository = Mockery::mock(EmployeeRepository::class);
        app()->instance(EmployeeRepository::class, $employeeRepository);

        $employee = factory(ModelEmployee::class)->make();
        $employee->wasRecentlyCreated = true;

        /**
         * Saying that EmployeeRepository->save should receive one instance of Models\Employee
         * and that the name and email should match with the what we sent when we call POST employees
         */
         $employeeRepository->shouldReceive('save')
            ->with(Mockery::on(function (ModelEmployee $receivedEmployee) use ($employee) {
                $receivedEmployee->wasRecentlyCreated = true;
                return $employee->name === $receivedEmployee->name
                    && $employee->email === $receivedEmployee->email;
            }))->andReturn(true);

        $response = $this->json('POST', '/api/v1/employees', $employee->toArray());
        $response->assertStatus(201);
        $response->assertJson($employee->toArray());
    }

    /**
     * @test
     */
    public function itShouldThrowExceptionOnSave()
    {
        $this->withoutMiddleware();

        // Mocking the EmployeeRepository
        $employeeRepository = Mockery::mock(EmployeeRepository::class);
        app()->instance(EmployeeRepository::class, $employeeRepository);

        $employee = factory(ModelEmployee::class)->make();
        $employee->wasRecentlyCreated = true;

        /**
         * Saying that EmployeeRepository->create should receive one instance of Entities\Employee
         * and that the name and email should match with the what we sent when we call POST employees
         */
        $employeeRepository->shouldReceive('save')
            ->with(Mockery::on(function (ModelEmployee $receivedEmployee) use ($employee) {
                return $employee->name === $receivedEmployee->name
                    && $employee->email === $receivedEmployee->email;
            }))->andReturn(false);

        $response = $this->json('POST', '/api/v1/employees', $employee->toArray());
        $response->assertStatus(500);
        $response->assertJson(['message' => 'Could not create employee']);
    }
}
