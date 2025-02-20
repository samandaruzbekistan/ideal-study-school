<?php

namespace App\Repositories;

use App\Models\Employee;

class EmployeeRepository
{
    public function getEmployees()
    {
        return Employee::orderBy('name', 'asc')->paginate(100);
    }

    public function getEmployeeById($id)
    {
        return Employee::find($id);
    }

    public function getEmployeeByIC($id_card)
    {
        return Employee::where('id_card', $id_card)->first();
    }

    public function getEmployeeByName($name)
    {
        return Employee::where('name', $name)->first();
    }

    public function updateIdCard($id, $id_card)
    {
        Employee::where('id', $id)->update([
            'id_card' => $id_card
        ]);
    }

    public function addEmployee($name, $position, $id_card)
    {
        $employee = new Employee;
        $employee->name = $name;
        $employee->position = $position;
        $employee->id_card = $id_card;
        $employee->save();
        return $employee->id;
    }
}
