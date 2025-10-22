<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cities = [
            ['name' => 'Москва'],
            ['name' => 'Санкт-Петербург'],
            ['name' => 'Новосибирск'],
            ['name' => 'Екатеринбург'],
            ['name' => 'Казань'],
            ['name' => 'Нижний Новгород'],
            ['name' => 'Челябинск'],
            ['name' => 'Самара'],
            ['name' => 'Омск'],
            ['name' => 'Ростов-на-Дону'],
            ['name' => 'Уфа'],
            ['name' => 'Красноярск'],
            ['name' => 'Воронеж'],
            ['name' => 'Пермь'],
            ['name' => 'Волгоград'],
            ['name' => 'Краснодар'],
        ];
    }
}
