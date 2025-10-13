<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::select(
                'employees.id_employee',
                'employees.last_name',
                'employees.first_name', 
                'employees.middle_name',
                'positions.name as position_name'
            )
            ->join('position_history', 'employees.id_employee', '=', 'position_history.id_employee')
            ->join('positions', 'position_history.id_position', '=', 'positions.id_position')
            ->whereNull('position_history.end_date') // только текущие должности
            ->orderBy('positions.name') // сортировка по должности
            ->orderBy('employees.last_name') // затем по фамилии
            ->orderBy('employees.first_name') // затем по имени
            ->orderBy('employees.middle_name') // затем по отчеству
            ->get();

        return view('employees.index', compact('employees'));
    }
}