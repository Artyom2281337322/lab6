<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use App\Models\Dismissal;
use Illuminate\Support\Carbon;

class EmployeeController extends Controller
{
    //1 запрос
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
//2 запрос
    public function index1()
    {
        // Используем метод из модели
        $employees = Employee::getWithSalaries();
        
        return view('employees.salaries', compact('employees'));
    }

    // Альтернативный метод с дополнительной обработкой
    public function indexWithFormatting()
    {
        $employees = Employee::getWithSalaries()
            ->map(function($employee) {
                // Добавляем форматированные данные
                $employee->formatted_salary = number_format($employee->salary, 0, '', ' ') . ' руб.';
                return $employee;
            });
        
        return view('employees.salaries', compact('employees'));
    }

    //3 запрос
     public function dismissed()
    {
        // Дата 3 года назад
        $threeYearsAgo = Carbon::now()->subYears(3);

        $dismissedEmployees = Employee::select(
                'employees.id_employee',
                'employees.last_name',
                'employees.first_name', 
                'employees.middle_name',
                'dismissals.date as dismissal_date',
                'dismissals.reason as dismissal_reason'
            )
            ->join('dismissals', 'employees.id_employee', '=', 'dismissals.id_employee')
            ->where('dismissals.date', '>=', $threeYearsAgo)
            ->orderBy('dismissals.date', 'DESC')
            ->get();

        return view('employees.dismissed', compact('dismissedEmployees'));
    }
}