<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\OrderStatus; // Импортируем модель OrderStatus

class OrderStatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Очищаем таблицу перед заполнением, если она не очищается migrate:fresh
        // OrderStatus::truncate(); // Можно использовать, если запускаете только этот сидер

        $statuses = [
            ['name' => 'Новый', 'description' => 'Заказ только что создан и ожидает обработки'],
            ['name' => 'В обработке', 'description' => 'Заказ принят в работу, уточнение деталей'],
            ['name' => 'Подтвержден', 'description' => 'Заказ подтвержден клиентом и готов к выполнению'],
            ['name' => 'Выполняется', 'description' => 'Установка/монтаж/обслуживание оборудования'],
            ['name' => 'Готов к отгрузке', 'description' => 'Оборудование упаковано и готово к отправке'],
            ['name' => 'Доставлен', 'description' => 'Оборудование доставлено клиенту'],
            ['name' => 'Завершен', 'description' => 'Заказ полностью выполнен и оплачен'],
            ['name' => 'Отменен', 'description' => 'Заказ был отменен клиентом или менеджером'],
            ['name' => 'Возврат', 'description' => 'Оформлен возврат оборудования/услуги'],
        ];

        foreach ($statuses as $status) {
            OrderStatus::firstOrCreate(
                ['name' => $status['name']], // Ищем по имени, чтобы избежать дубликатов
                ['description' => $status['description']]
            );
        }
    }
}