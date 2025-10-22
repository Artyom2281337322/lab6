<?php
// database/seeders/DatabaseSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            PositionSeeder::class,
            CitySeeder::class,
            DepartmentSeeder::class,
            EmployeeSeeder::class,
            PositionHistorySeeder::class,
            DismissalSeeder::class,
        ]);
    }
}