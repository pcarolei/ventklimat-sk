<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role; // Не забудьте импортировать модель Role

class RolesTableSeeder extends Seeder
{
    /**
     * Запускает сиды базы данных.
     */
    public function run(): void
    {
        // Создаем или находим роль 'admin'
        Role::firstOrCreate(['name' => 'admin']);
        // Создаем или находим роль 'client'
        Role::firstOrCreate(['name' => 'client']);
    }
}