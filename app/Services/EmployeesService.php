<?php

namespace App\Services;

use App\Entities\Employee;
use App\Exceptions\BusinessException;
use App\Models\Employee as ModelEmployee;
use App\Repositories\EmployeeRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

/**
 * Class EmployeesService
 * @package App\Services
 *
 * All the logic and rules should go inside services
 * This layer should not use $_SESSION,$_GET,$_POST,$_SERVER,$_REQUEST
 */
class EmployeesService
{
    /**
     * @var EmployeeRepository
     */
    private EmployeeRepository $employeeRepository;

    /**
     * EmployeesService constructor.
     * @param EmployeeRepository $employeeRepository
     */
    public function __construct(EmployeeRepository $employeeRepository)
    {
        $this->employeeRepository = $employeeRepository;
    }

    /**
     * @param int $id
     * @return ModelEmployee|null
     */
    public function find(int $id): ?ModelEmployee
    {
        return $this->employeeRepository->find($id);
    }

    /**
     * @return Collection
     */
    public function employees(): Collection
    {
        return $this->employeeRepository->employees();
    }

    /**
     * @param Employee $employee
     * @return ModelEmployee
     * @throws ValidationException
     * @throws BusinessException
     */
    public function create(Employee $employee): ModelEmployee
    {
        /**
        * Here we are validating that is mandatory to create an Employee
        */
        $this->validate($employee->jsonSerialize(), [
            'name' => 'required',
            'email' => 'required|email|unique:employees,email',
        ]);
        $modelEmployee = new ModelEmployee();
        $modelEmployee->name = $employee->getName();
        $modelEmployee->email = $employee->getEmail();

        if (!$this->employeeRepository->save($modelEmployee)) {
            throw new BusinessException("Could not create employee");
        }

        return $modelEmployee;
    }

    /**
     * @param Employee $employee
     * @return ModelEmployee
     * @throws ValidationException
     * @throws BusinessException
     */
    public function update(ModelEmployee $employee): ModelEmployee
    {
        /**
        * Here we are validating that is mandatory to update an Employee
        */
        $this->validate($employee->toArray(), [
            'id' => 'required|exists:employees,id',
            'name' => 'required',
            'email' => 'required|email|unique:employees,email,'.$employee->id
        ]);
        $modelEmployee = $this->employeeRepository->find($employee->id);
        $modelEmployee->name = $employee->name;
        $modelEmployee->email = $employee->email;

        if (!$this->employeeRepository->save($modelEmployee)) {
            throw new BusinessException("Could not update employee");
        }

        return $modelEmployee;
    }

    /**
     * @param int $id
     */
    public function delete(int $id): void
    {
        $this->validate(['id' => $id],[
            'id' => 'required|exists:employees,id'
        ]);
        $this->employeeRepository->delete($id);
    }

    /**
     * @param array $data
     * @param array $rules
     * @throws ValidationException
     */
    private function validate(array $data, array $rules) :void
    {
        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            throw ValidationException::withMessages($validator->errors()->messages());
        }
    }
}
