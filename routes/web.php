<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Здесь вы можете зарегистрировать веб-маршруты для вашего приложения.
| Эти маршруты загружаются RouteServiceProvider и будут назначены
| группе middleware "web". Сделайте что-нибудь великое!
|
*/

// Главная страница:
// Если пользователь авторизован, перенаправляем его на соответствующую страницу в зависимости от роли.
// Если не авторизован, показываем страницу-визитку.
Route::get('/', function () {
    if (Auth::check()) {
        $user = Auth::user();
        // Если пользователь - администратор или менеджер, на дашборд
        if ($user->role->name === 'admin' || $user->role->name === 'manager') {
            return redirect()->route('dashboard');
        }
        // Если пользователь - клиент, на страницу заказов
        elseif ($user->role->name === 'client') {
            return redirect()->route('orders.index');
        }
        // Fallback для других ролей или если роль не определена
        return redirect()->route('welcome'); // Можно перенаправить на welcome или другую страницу
    }
    return (new WelcomeController())->index(); // Показываем визитку через контроллер
})->name('welcome');

// Группа маршрутов, требующих аутентификации
Route::middleware('auth')->group(function () {

    // Маршруты для профиля (доступны всем авторизованным пользователям)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Маршруты для заказов (доступны всем авторизованным пользователям)
    // Фильтрация по user_id для клиентов происходит в OrderController::index
    // Политики управляют доступом к конкретным действиям (create, update, delete)
    Route::resource('orders', OrderController::class);

    // Группа маршрутов, требующих подтверждения email (verified)
    // А также ограничение по ролям для Дашборда и Услуг
    Route::middleware('verified')->group(function () {
        // Дашборд доступен только администраторам и менеджерам
        Route::get('/dashboard', [DashboardController::class, 'index'])
             ->middleware('role:admin,manager')
             ->name('dashboard');

        // Услуги доступны только администраторам и менеджерам
        Route::resource('services', ServiceController::class)
             ->middleware('role:admin,manager');
    });
});

// Подключаем маршруты аутентификации Laravel Breeze (login, register, logout и т.д.)
require __DIR__ . '/auth.php';
