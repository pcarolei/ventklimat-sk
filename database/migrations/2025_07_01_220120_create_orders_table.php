<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Заказчик
            $table->foreignId('service_id')->constrained('services')->onDelete('restrict'); // Какая услуга заказана (restrict - не даст удалить услугу, если на нее есть заказы)
            $table->text('description'); // Детализация заказа от пользователя
            $table->foreignId('order_status_id')->constrained('order_statuses')->onDelete('restrict'); // Текущий статус заказа
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};