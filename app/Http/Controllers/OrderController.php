<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order; // Импортируем модель Order

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::all(); // Получаем все заказы
        return view('orders.index', compact('orders'));
    }
}
