<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Добавляем nullable() на случай, если у вас уже есть пользователи без role_id
            // и вы хотите добавить его позже вручную или через сидер.
            // В нашем случае, если база данных пуста, можно и без nullable()
            // и сразу назначить дефолтное значение или требовать его при создании.
            // Но для безопасности и гибкости:
            $table->foreignId('role_id')
                  ->nullable() // Сначала делаем nullable, потом обновляем, потом можно сделать notNullable()
                  ->after('password') // Размещаем поле после password
                  ->constrained('roles')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['role_id']); // Удаляем внешний ключ
            $table->dropColumn('role_id');    // Удаляем столбец
        });
    }
};