<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\OrderStatus; // Не забудьте импортировать модель OrderStatus

class OrderStatusesTableSeeder extends Seeder
{
    /**
     * Запускает сиды базы данных.
     */
    public function run(): void
    {
        // Определяем стандартные статусы заказа
        OrderStatus::firstOrCreate(['name' => 'pending']);    // Ожидает рассмотрения/подтверждения
        OrderStatus::firstOrCreate(['name' => 'processing']); // В работе / выполняется
        OrderStatus::firstOrCreate(['name' => 'completed']);  // Завершен / выполнен
        OrderStatus::firstOrCreate(['name' => 'cancelled']);  // Отменен
        // Можно добавить другие статусы, если они понадобятся, например:
        // OrderStatus::firstOrCreate(['name' => 'on_hold']);  // Приостановлен
        // OrderStatus::firstOrCreate(['name' => 'rejected']); // Отклонен (администратором)
    }
}