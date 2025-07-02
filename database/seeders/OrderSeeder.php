<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\User;
use App\Models\OrderStatus;
use App\Models\Service; // Убедитесь, что Service импортирован
use Faker\Factory as Faker;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('ru_RU');

        $users = User::all();
        $orderStatuses = OrderStatus::all();
        $services = Service::all(); // Получаем все услуги

        if ($users->isEmpty() || $orderStatuses->isEmpty() || $services->isEmpty()) {
            $this->command->info('Недостаточно данных для создания заказов. Убедитесь, что UsersTableSeeder, OrderStatusesTableSeeder и ServicesTableSeeder запущены ПЕРЕД OrderSeeder.');
            return;
        }

        $orderDescriptions = [
            'Установка сплит-системы в квартире (гостиная)',
            'Сервисное обслуживание вентиляции офисного здания',
            'Ремонт промышленного кондиционера Daikin на складе',
            'Проектирование системы кондиционирования для нового магазина',
            'Монтаж воздуховодов в цеху производства',
            'Диагностика и чистка домашней сплит-системы',
            'Заправка фреоном кондиционера Samsung',
            'Установка мульти-сплит системы в коттедже',
            'Демонтаж старой вентиляционной системы',
            'Подключение VRF системы',
            'Настройка автоматики приточной вентиляции',
            'Ежеквартальное обслуживание климатического оборудования',
            'Доставка и установка тепловой пушки',
            'Консультация по выбору увлажнителя воздуха',
            'Устранение утечки хладагента',
        ];

        // Создаем, например, 70 тестовых заказов
        for ($i = 0; $i < 70; $i++) {
            $user = $users->random();
            $status = $orderStatuses->random();
            $totalAmount = $faker->randomFloat(2, 5000, 150000);
        
            $order = Order::create([ // Измените на $order = Order::create
                'user_id' => $user->id,
                'order_status_id' => $status->id,
                'total_amount' => $totalAmount,
                'details' => $faker->randomElement($orderDescriptions) . ' - ' . $faker->sentence(5),
                'created_at' => $faker->dateTimeBetween('-2 years', 'now'),
                'updated_at' => $faker->dateTimeBetween('-1 year', 'now'),
            ]);
        
            // Прикрепляем 1-3 случайные услуги к каждому заказу
            $randomServices = $services->random(rand(1, 3))->pluck('id');
            $order->services()->attach($randomServices); // Используем отношение many-to-many
        }
    }
}