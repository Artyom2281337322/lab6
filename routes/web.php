<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/employees', [EmployeeController::class, 'index'])->name('employees.index');

Route::get('/employees/salaries', [EmployeeController::class, 'index'])
    ->name('employees.salaries');


Route::get('/salaries', [EmployeeController::class, 'indexWithFormatting'])
    ->name('salaries.index');

Route::get('/employees/dismissed', [EmployeeController::class, 'dismissed'])
    ->name('employees.dismissed');

Route::get('/employees/departments', [EmployeeController::class, 'departments'])
    ->name('employees.departments');

Route::get('/employees/departments-stats', [EmployeeController::class, 'departmentsStats'])
    ->name('employees.departments-stats');

Route::get('/employees/high-paid-programmers', [EmployeeController::class, 'highPaidProgrammers'])
    ->name('employees.high-paid-programmers');

Route::get('/employees/long-term', [EmployeeController::class, 'longTermEmployees'])
    ->name('employees.long-term');

Route::get('/employees/select-employee', [EmployeeController::class, 'selectEmployee'])
    ->name('employees.select-employee');

Route::post('/employees/position-history', [EmployeeController::class, 'employeePositionHistory'])
    ->name('employees.position-history');

Route::get('/employees/dismissal-stats', [EmployeeController::class, 'dismissalStatsWithTotal'])
    ->name('employees.dismissal-stats');

Route::get('/employees/cities', [EmployeeController::class, 'employeesCities'])
    ->name('employees.cities');

Route::get('/employees/moscow-programmers', [EmployeeController::class, 'moscowProgrammers'])
    ->name('employees.moscow-programmers');
