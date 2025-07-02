<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ServiceController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Редирект с корня сайта: авторизованные на дашборд, неавторизованные на логин
Route::get('/', function () {
    if (Auth::check()) { // Если пользователь авторизован
        return redirect()->route('dashboard'); // Перенаправить на дашборд
    }
    return redirect()->route('login'); // Иначе перенаправить на страницу входа
});

// Группа маршрутов, требующих аутентификации
Route::middleware('auth')->group(function () {

    // Маршруты для профиля (доступны всем авторизованным пользователям)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Маршруты для заказов (доступны всем авторизованным пользователям, фильтрация в контроллере/политике)
    Route::resource('orders', OrderController::class);

    // Группа маршрутов, требующих аутентификации и верификации email
    // А также ограничение по ролям для Дашборда и Услуг
    Route::middleware('verified')->group(function () { // 'verified' внутри 'auth'
        // Дашборд доступен только администраторам и менеджерам
        Route::get('/dashboard', [DashboardController::class, 'index'])
             ->middleware('role:admin,manager') // <-- Middleware 'role' для ограничения доступа
             ->name('dashboard');

        // Услуги доступны только администраторам и менеджерам
        Route::resource('services', ServiceController::class)
             ->middleware('role:admin,manager'); // <-- Middleware 'role' для ограничения доступа
    });
});

require __DIR__ . '/auth.php';
