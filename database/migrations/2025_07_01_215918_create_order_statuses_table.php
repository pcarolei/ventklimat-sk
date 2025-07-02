<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        schema::create('order_statuses', function (blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->text('description')->nullable(); // добавляем столбец 'description'
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_statuses');
    }
};