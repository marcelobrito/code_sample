<?php

namespace App\Http\Controllers;

use App\Factories\EmployeeFactory;
use Illuminate\Http\Request;
use App\Services\EmployeesService;
use Illuminate\Support\Collection;
use App\Models\Employee as ModelEmployee;

/**
 * Class EmployeesController
 * @package App\Http\Controllers
 */
class EmployeesController extends Controller
{
    /**
     * @var EmployeesService
     */
    private EmployeesService $employeesService;

    /**
     * EmployeesController constructor.
     * @param EmployeesService $employeesService
     *
     * Injecting the class EmployeesService in the class constructor.
     * Laravel Container, part of the Dependency inject framework in instantiating
     * the class for us
     */
    public function __construct(EmployeesService $employeesService)
    {
        $this->employeesService = $employeesService;
    }

    /**
     * @return Collection
     */
    public function index(): Collection
    {
        return $this->employeesService->employees();
    }

    /**
     * @param Request $request
     * @return ModelEmployee
     * @throws \Illuminate\Validation\ValidationException
     */
    public function employee(Request $request): ModelEmployee
    {
        /** validating only the types */
        $this->validate($request, ['id' => 'int']);

        $employee = $this->employeesService->find($request->id);
        if (empty($employee)) {
            abort(404);
        }

        return $employee;
    }

    /**
     * @param Request $request
     * @return ModelEmployee
     * @throws \Illuminate\Validation\ValidationException
     * @throws \RuntimeException
     */
    public function create(Request $request): ModelEmployee
    {
        /** validating only the types */
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required'
        ]);
        /**
         * Use factories to build complex objects,
         * we do not need a factory for Employee but I added it just as an example
         */
        $employee = EmployeeFactory::build($request->all());
        return $this->employeesService->create($employee);
    }

    /**
     * @param Request $request
     * @return ModelEmployee
     * @throws \Illuminate\Validation\ValidationException
     * @throws \RuntimeException
     */
    public function update(Request $request, $id): ModelEmployee
    {
        /** validating only the types */
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required'
        ]);

        /**
         * Considering that we are using Laravel, we could just send the Model as an Entity
         *
         */
        $modelEmployee = new ModelEmployee();
        $modelEmployee->id = $id;
        $modelEmployee->name = $request->get('name');
        $modelEmployee->email = $request->get('email');

        return $this->employeesService->update($modelEmployee);
    }

    /**
     * @param Request $request
     * @throws \Illuminate\Validation\ValidationException
     */
    public function delete(Request $request)
    {
        $this->validate($request, ['id' => 'int']);
        $this->employeesService->delete($request->id);
    }
}
