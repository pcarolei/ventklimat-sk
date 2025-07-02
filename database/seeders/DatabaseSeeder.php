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
            UsersTableSeeder::class,      // Пользователи создаются после ролей
            OrderStatusesTableSeeder::class,
            ServicesTableSeeder::class,
            OrderSeeder::class,
        ]);
    }
}