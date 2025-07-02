<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use App\Models\OrderStatus; // Убедитесь, что эта модель импортирована

class DashboardController extends Controller
{
    public function index()
    {
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
        // Предполагаем, что у вас есть роль 'client'
        $clientRoleId = \App\Models\Role::where('name', 'client')->first()->id ?? null;
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

        return view('dashboard', compact(
            'totalOrders', 'newOrders', 'processingOrders', 'completedOrders', 'lastYearAmount',
            'totalClients', 'newClientsLastMonth', 'latestOrders'
        ));
    }
}