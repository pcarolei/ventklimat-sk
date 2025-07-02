<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Service; // Импортируем модель Service

class ServicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Service::truncate(); // Можно использовать, если запускаете только этот сидер

        $services = [
            ['name' => 'Установка кондиционера', 'description' => 'Монтаж бытовых и промышленных кондиционеров', 'price' => 7500.00],
            ['name' => 'Обслуживание вентиляции', 'description' => 'Плановое техническое обслуживание систем вентиляции', 'price' => 4500.00],
            ['name' => 'Ремонт чиллера', 'description' => 'Диагностика и ремонт холодильных машин (чиллеров)', 'price' => 15000.00],
            ['name' => 'Проектирование системы ОВК', 'description' => 'Разработка проектной документации для систем отопления, вентиляции и кондиционирования', 'price' => 30000.00],
            ['name' => 'Монтаж воздуховодов', 'description' => 'Установка и герметизация воздуховодных систем', 'price' => 9000.00],
            ['name' => 'Диагностика сплит-системы', 'description' => 'Полная диагностика неисправностей сплит-систем', 'price' => 2500.00],
            ['name' => 'Чистка кондиционера', 'description' => 'Глубокая чистка внутренних и внешних блоков', 'price' => 3000.00],
            ['name' => 'Заправка фреоном', 'description' => 'Дозаправка и полная заправка хладагентом (фреоном)', 'price' => 4000.00],
        ];

        foreach ($services as $service) {
            Service::firstOrCreate(
                ['name' => $service['name']],
                [
                    'description' => $service['description'],
                    'price' => $service['price']
                ]
            );
        }
    }
}