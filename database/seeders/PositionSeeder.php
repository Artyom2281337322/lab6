<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $positions = [
            ['name' => 'Директор', 'salary' => 150000],
            ['name' => 'Заместитель директора', 'salary' => 120000],
            ['name' => 'Начальник отдела', 'salary' => 100000],
            ['name' => 'Менеджер проекта', 'salary' => 90000],
            ['name' => 'Старший разработчик', 'salary' => 110000],
            ['name' => 'Разработчик', 'salary' => 80000],
            ['name' => 'Младший разработчик', 'salary' => 60000],
            ['name' => 'Системный администратор', 'salary' => 75000],
            ['name' => 'Бухгалтер', 'salary' => 70000],
            ['name' => 'Старший бухгалтер', 'salary' => 85000],
            ['name' => 'Менеджер по продажам', 'salary' => 65000],
            ['name' => 'Маркетолог', 'salary' => 70000],
            ['name' => 'HR-специалист', 'salary' => 60000],
            ['name' => 'Аналитик', 'salary' => 90000],
            ['name' => 'Тестировщик', 'salary' => 55000],
            ['name' => 'Дизайнер', 'salary' => 65000],
            ['name' => 'Технический писатель', 'salary' => 50000],
            ['name' => 'Секретарь', 'salary' => 40000],
        ];
    }
}
