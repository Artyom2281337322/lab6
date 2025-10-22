<?php
// database/seeders/EmployeeSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Employee;
use App\Models\Department;
use App\Models\City;
use Illuminate\Support\Facades\DB;

class EmployeeSeeder extends Seeder
{
    public function run()
    {
        // Проверяем, есть ли данные в связанных таблицах
        if (Department::count() == 0 || City::count() == 0) {
            $this->command->error('Сначала заполните таблицы departments и cities!');
            return;
        }

        $maleFirstNames = ['Александр', 'Сергей', 'Дмитрий', 'Андрей', 'Алексей', 'Максим', 'Иван', 'Михаил', 'Владимир', 'Евгений'];
        $femaleFirstNames = ['Елена', 'Ольга', 'Ирина', 'Наталья', 'Мария', 'Светлана', 'Анна', 'Татьяна', 'Юлия', 'Екатерина'];
        
        $maleLastNames = ['Иванов', 'Петров', 'Сидоров', 'Смирнов', 'Кузнецов', 'Попов', 'Васильев', 'Фёдоров', 'Морозов', 'Волков'];
        $femaleLastNames = ['Иванова', 'Петрова', 'Сидорова', 'Смирнова', 'Кузнецова', 'Попова', 'Васильева', 'Фёдорова', 'Морозова', 'Волкова'];
        
        $middleNames = ['Александрович', 'Сергеевич', 'Дмитриевич', 'Андреевич', 'Алексеевич', 'Иванович', 'Михайлович', 'Владимирович'];

        $departments = Department::all();
        $cities = City::all();

        $employees = [];

        // Создаем 20 сотрудников
        for ($i = 0; $i < 20; $i++) {
            $isMale = rand(0, 1);
            
            if ($isMale) {
                $firstName = $maleFirstNames[array_rand($maleFirstNames)];
                $lastName = $maleLastNames[array_rand($maleLastNames)];
                $middleName = $middleNames[array_rand($middleNames)];
            } else {
                $firstName = $femaleFirstNames[array_rand($femaleFirstNames)];
                $lastName = $femaleLastNames[array_rand($femaleLastNames)];
                $middleName = $middleNames[array_rand($middleNames)] . 'на';
            }

            // Генерируем дату рождения (от 20 до 60 лет)
            $birthDate = now()->subYears(rand(20, 60))->subDays(rand(0, 365));

            $employees[] = [
                'last_name' => $lastName,
                'first_name' => $firstName,
                'middle_name' => $middleName,
                'gender' => $isMale ? 'М' : 'Ж',
                'birth_date' => $birthDate->format('Y-m-d'),
                'department_id' => $departments->random()->department_id,
                'city_id' => $cities->random()->city_id,
            ];
        }

        // Используем массовую вставку для оптимизации
        DB::table('employees')->insert($employees);
    }
}