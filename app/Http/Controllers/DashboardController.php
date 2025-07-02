<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Добавьте импорт Auth
use App\Models\Order;
use App\Models\User;
use App\Models\OrderStatus;
use App\Models\Role; // Добавьте импорт Role, если используете ее явно для получения clientRoleId

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user(); // Получаем текущего авторизованного пользователя

        // Инициализируем переменные по умолчанию для всех ролей
        $totalOrders = 0;
        $newOrders = 0;
        $processingOrders = 0;
        $completedOrders = 0;
        $lastYearAmount = 0;
        $totalClients = 0;
        $newClientsLastMonth = 0;
        $latestOrders = collect(); // Пустая коллекция для последних заказов

        // Только если пользователь - администратор или менеджер, получаем полную статистику
        if ($user->role->name === 'admin' || $user->role->name === 'manager') {
            // Получаем необходимые ID статусов
            $newStatusId = OrderStatus::where('name', 'Новый')->first()->id ?? null;
            $processingStatusesIds = OrderStatus::whereIn('name', ['В обработке', 'Подтвержден', 'Выполняется'])->pluck('id')->toArray();
            $completedStatusId = OrderStatus::where('name', 'Завершен')->first()->id ?? null;

            // Сводка по заказам
            $totalOrders = Order::count();
            $newOrders = Order::when($newStatusId, function ($query) use ($newStatusId) {
                                return $query->where('order_status_id', $newStatusId);
                            })->count();
            $processingOrders = Order::when(!empty($processingStatusesIds), function ($query) use ($processingStatusesIds) {
                                    return $query->whereIn('order_status_id', $processingStatusesIds);
                                })->count();
            $completedOrders = Order::when($completedStatusId, function ($query) use ($completedStatusId) {
                                    return $query->where('order_status_id', $completedStatusId);
                                })->count();

            // Сумма завершенных заказов за последний год
            $lastYearAmount = Order::where('created_at', '>=', now()->subYear())
                                   ->when($completedStatusId, function ($query) use ($completedStatusId) {
                                        return $query->where('order_status_id', $completedStatusId);
                                   })
                                   ->sum('total_amount');

            // Сводка по клиентам (пользователям с ролью клиента)
            $clientRoleId = Role::where('name', 'client')->first()->id ?? null;
            $totalClients = User::when($clientRoleId, function ($query) use ($clientRoleId) {
                                return $query->where('role_id', $clientRoleId);
                            })->count();
            $newClientsLastMonth = User::when($clientRoleId, function ($query) use ($clientRoleId) {
                                        return $query->where('role_id', $clientRoleId);
                                    })
                                    ->where('created_at', '>=', now()->subMonth())
                                    ->count();

            // Последние 10 заказов
            $latestOrders = Order::with('user', 'orderStatus')->latest()->take(10)->get();
        }
        // Если пользователь не админ и не менеджер (т.е. клиент),
        // все переменные останутся инициализированными нулями или пустой коллекцией.

        return view('dashboard', compact(
            'totalOrders', 'newOrders', 'processingOrders', 'completedOrders', 'lastYearAmount',
            'totalClients', 'newClientsLastMonth', 'latestOrders'
        ));
    }
}