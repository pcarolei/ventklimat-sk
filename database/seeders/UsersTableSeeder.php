<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;  // Импортируем модель User
use App\Models\Role;  // Импортируем модель Role
use Illuminate\Support\Facades\Hash; // Импортируем фасад Hash

class UsersTableSeeder extends Seeder
{
    /**
     * Запускает сиды базы данных.
     */
    public function run(): void
    {
        // Получаем или создаем роль "admin"
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        // Получаем или создаем роль "client"
        $clientRole = Role::firstOrCreate(['name' => 'client']);

        // Создаем тестового администратора
        User::firstOrCreate(
            ['email' => 'admin@example.com'], // Проверяем по email, чтобы не дублировать
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'), // Пароль: 'password'
                'role_id' => $adminRole->id,
                'email_verified_at' => now(), // Помечаем email как подтвержденный
            ]
        );

        // Создаем тестового клиента
        User::firstOrCreate(
            ['email' => 'client@example.com'], // Проверяем по email, чтобы не дублировать
            [
                'name' => 'Client User',
                'password' => Hash::make('password'), // Пароль: 'password'
                'role_id' => $clientRole->id,
                'email_verified_at' => now(), // Помечаем email как подтвержденный
            ]
        );

        // Можно добавить еще тестовых пользователей, если нужно
        // User::firstOrCreate(
        //     ['email' => 'anotherclient@example.com'],
        //     [
        //         'name' => 'Another Client',
        //         'password' => Hash::make('password'),
        //         'role_id' => $clientRole->id,
        //         'email_verified_at' => now(),
        //     ]
        // );
    }
}