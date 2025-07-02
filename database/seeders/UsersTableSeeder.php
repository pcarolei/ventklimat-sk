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
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $managerRole = Role::firstOrCreate(['name' => 'manager']);
        $clientRole = Role::firstOrCreate(['name' => 'client']);

        // Создаем администратора
        User::firstOrCreate(
            ['email' => 'admin@example.com'], // Уникальное поле для поиска
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'), // Пароль 'password'
                'role_id' => $adminRole->id,
                'email_verified_at' => now(), // Подтверждаем email
            ]
        );

        // Создаем менеджера
        User::firstOrCreate(
            ['email' => 'manager@example.com'],
            [
                'name' => 'Manager User',
                'password' => Hash::make('password'),
                'role_id' => $managerRole->id,
                'email_verified_at' => now(),
            ]
        );

        // Создаем клиента
        User::firstOrCreate(
            ['email' => 'client@example.com'],
            [
                'name' => 'Client User',
                'password' => Hash::make('password'),
                'role_id' => $clientRole->id,
                'email_verified_at' => now(),
            ]
        );

        // Создаем еще несколько случайных клиентов с помощью фабрики
        // Убедитесь, что UserFactory настроен для назначения role_id
        User::factory()->count(5)->create([
            'role_id' => $clientRole->id,
        ]);

    }
}