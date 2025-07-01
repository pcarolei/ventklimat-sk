<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Запускает сиды приложения.
     */
    public function run(): void
    {
        $this->call([
            RolesTableSeeder::class,      // Роли должны быть созданы первыми
            OrderStatusesTableSeeder::class,
            ServicesTableSeeder::class,
            UsersTableSeeder::class,      // Пользователи создаются после ролей
        ]);
    }
}