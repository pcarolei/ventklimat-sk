<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order; // Импортируем модель Order

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user', 'orderStatus')->latest()->get(); // Загружаем связанные данные
        return view('orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        // Загружаем связанные данные для детального просмотра
        // Если у вас связь Order с Service через pivot-таблицу 'order_service',
        // используйте with('user', 'orderStatus', 'services')
        $order->load('user', 'orderStatus', 'services'); // Загружаем связанные модели

        return view('orders.show', compact('order'));
    }
}
