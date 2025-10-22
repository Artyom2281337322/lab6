<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/employees', [EmployeeController::class, 'index'])->name('employees.index');

Route::get('/employees/salaries', [EmployeeController::class, 'index'])
    ->name('employees.salaries');

// Альтернативный маршрут (если нужен)
Route::get('/salaries', [EmployeeController::class, 'indexWithFormatting'])
    ->name('salaries.index');

Route::get('/employees/dismissed', [EmployeeController::class, 'dismissed'])
    ->name('employees.dismissed');
