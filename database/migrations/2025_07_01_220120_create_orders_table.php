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
    
            // Убедитесь, что эти foreign keys присутствуют и правильно определены:
            $table->foreignId('user_id')
                  ->constrained() // Связывает с таблицей 'users'
                  ->onDelete('cascade'); // Если пользователь удаляется, его заказы тоже удаляются
    
            $table->foreignId('order_status_id')
                  ->constrained('order_statuses') // Связывает с таблицей 'order_statuses'
                  ->onDelete('cascade');
    
            // Добавляем столбец 'total_amount':
            $table->decimal('total_amount', 12, 2); // Пример: 1234567890.12, без nullable, так как это обязательная сумма
    
            // Добавляем столбец 'details':
            $table->text('details')->nullable(); // Может быть null, если нет специфических деталей
    
            $table->timestamps(); // Добавляет created_at и updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};