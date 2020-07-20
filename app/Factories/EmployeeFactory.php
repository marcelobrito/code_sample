<?php

namespace App\Factories;

use Illuminate\Support\Arr;
use App\Entities\Employee;

/**
 * Class EmployeeFactory
 * @package App\Factories
 *
 * Use factories to build complex objects,
 * we do not need a factory for Employee but I added it just as an example
 */
class EmployeeFactory
{
    /**
     * @param array $data
     * @return Employee
     */
    public static function build(array $data)
    {
        return new Employee(Arr::get($data, 'id', 0), $data['name'], $data['email']);
    }
}
