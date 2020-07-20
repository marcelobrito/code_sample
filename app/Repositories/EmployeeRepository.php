<?php


namespace App\Repositories;

use App\Models\Employee;
use Illuminate\Support\Collection;

/**
 * Class EmployeeRepository
 * @package App\Repositories
 *
 * Use repositories to comunicate with the database
 * Here you should only insert/update/delete/select data
 * All the logic should be in the services
 * This layer should not use $_SESSION,$_GET,$_POST,$_SERVER,$_REQUEST
 */
class EmployeeRepository
{
    public function find(int $id)
    {
        return Employee::find($id);
    }

    public function employees(): Collection
    {
        return Employee::all();
    }

    public function save(Employee $employee): bool
    {
        return $employee->save();
    }

    public function delete(int $id): void
    {
        Employee::find($id)->delete();
    }
}
