<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    { 
        $departments = [
            ['name' => 'Отдел разработки'],
            ['name' => 'Отдел тестирования'],
            ['name' => 'Отдел аналитики'],
            ['name' => 'Отдел маркетинга'],
            ['name' => 'Отдел продаж'],
            ['name' => 'Бухгалтерия'],
            ['name' => 'Отдел кадров'],
            ['name' => 'Техническая поддержка'],
            ['name' => 'Отдел дизайна'],
            ['name' => 'Отдел качества'],
            ['name' => 'Исследовательский отдел'],
            ['name' => 'Производственный отдел'],
            ['name' => 'Логистический отдел'],
            ['name' => 'Юридический отдел'],
            ['name' => 'Административный отдел'],
            ['name' => 'Финансовый отдел'],
        ];
    }
}
