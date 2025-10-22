<?php
// database/seeders/DismissalSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Dismissal;
use App\Models\Employee;
use Illuminate\Support\Facades\DB;

class DismissalSeeder extends Seeder
{
    public function run()
    {
        // Проверяем, есть ли сотрудники
        if (Employee::count() == 0) {
            $this->command->error('Сначала заполните таблицу employees!');
            return;
        }

        $employees = Employee::all();
        $reasons = [
            'По собственному желанию',
            'Сокращение штата',
            'Несоответствие занимаемой должности',
            'Нарушение трудовой дисциплины',
            'Окончание срока контракта',
            'По соглашению сторон',
            'В связи с выходом на пенсию',
        ];

        $dismissals = [];

        // Увольняем 8 случайных сотрудников (но не больше, чем есть)
        $employeesToDismiss = $employees->random(min(8, $employees->count()));

        foreach ($employeesToDismiss as $employee) {
            $dismissalDate = now()->subDays(rand(1, 365));

            $dismissals[] = [
                'employee_id' => $employee->employee_id,
                'date' => $dismissalDate->format('Y-m-d'),
                'reason' => $reasons[array_rand($reasons)],
            ];
        }

        DB::table('dismissals')->insert($dismissals);
    }
}