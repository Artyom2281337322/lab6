<?php
// database/seeders/PositionHistorySeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PositionHistory;
use App\Models\Employee;
use App\Models\Position;
use Illuminate\Support\Facades\DB;

class PositionHistorySeeder extends Seeder
{
    public function run()
    {
        // Проверяем, есть ли сотрудники и должности
        if (Employee::count() == 0 || Position::count() == 0) {
            $this->command->error('Сначала заполните таблицы employees и positions!');
            return;
        }

        $employees = Employee::all();
        $positions = Position::all();

        $positionHistories = [];

        foreach ($employees as $employee) {
            // У каждого сотрудника от 1 до 3 записей в истории должностей
            $recordCount = rand(1, 3);
            $currentDate = now()->subYears(rand(1, 10));

            for ($i = 0; $i < $recordCount; $i++) {
                $startDate = $currentDate->copy();
                
                if ($i == $recordCount - 1) {
                    // Последняя запись - текущая должность
                    $endDate = null;
                } else {
                    // Прошлые должности
                    $endDate = $startDate->copy()->addMonths(rand(6, 36));
                    $currentDate = $endDate->copy()->addDay();
                }

                $positionHistories[] = [
                    'employee_id' => $employee->employee_id,
                    'position_id' => $positions->random()->position_id,
                    'start_date' => $startDate->format('Y-m-d'),
                    'end_date' => $endDate ? $endDate->format('Y-m-d') : null,
                ];
            }
        }

        DB::table('position_histories')->insert($positionHistories);
    }
}