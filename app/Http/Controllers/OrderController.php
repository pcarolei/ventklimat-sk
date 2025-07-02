<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Service;
use App\Models\User;
use App\Models\OrderStatus; // Убедитесь, что OrderStatus импортирован
use App\Models\Role; // Убедитесь, что Role импортирован
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule; // Убедитесь, что Rule импортирован

class OrderController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Order::class);

        $user = Auth::user();
        $orders = collect();

        if ($user->role->name === 'admin' || $user->role->name === 'manager') {
            $orders = Order::all();
        } elseif ($user->role->name === 'client') {
            $orders = Order::where('user_id', $user->id)->get();
        }

        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        $this->authorize('create', Order::class);
        $services = Service::all();
        $clients = User::whereHas('role', function($query) {
            $query->where('name', 'client');
        })->get();
        $orderStatuses = OrderStatus::all(); // <-- Добавлено для create

        return view('orders.create', compact('services', 'clients', 'orderStatuses')); // <-- Передаем orderStatuses
    }

    public function store(Request $request)
    {
        $this->authorize('create', Order::class);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'service_id' => 'required|exists:services,id',
            'user_id' => ['required', 'exists:users,id', Rule::exists('users', 'id')->where(function ($query) {
                $clientRoleId = Role::where('name', 'client')->first()->id;
                $query->where('role_id', $clientRoleId);
            })],
            'order_status_id' => 'required|exists:order_statuses,id', // Добавлено для валидации статуса
            'total_amount' => 'required|numeric|min:0', // Добавлено для валидации суммы
        ]);

        if (Auth::user()->role->name === 'client') {
            $validated['user_id'] = Auth::id();
        }

        $order = Order::create($validated);

        // Прикрепляем выбранные услуги (если есть)
        if ($request->has('services')) {
            $order->services()->attach($request->input('services'));
        }

        return redirect()->route('orders.index')->with('success', 'Заказ успешно создан.');
    }

    public function show(Order $order)
    {
        $this->authorize('view', $order);
        $order->load('user', 'orderStatus', 'services'); // Убедитесь, что загружаются отношения
        return view('orders.show', compact('order'));
    }

    public function edit(Order $order)
    {
        $this->authorize('update', $order);
        $services = Service::all();
        $clients = User::whereHas('role', function($query) {
            $query->where('name', 'client');
        })->get();
        $orderStatuses = OrderStatus::all(); // <-- Добавлено: получаем все статусы заказа

        return view('orders.edit', compact('order', 'services', 'clients', 'orderStatuses')); // <-- Передаем orderStatuses
    }

    public function update(Request $request, Order $order)
    {
        $this->authorize('update', $order);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'service_id' => 'required|exists:services,id',
            'user_id' => ['required', 'exists:users,id', Rule::exists('users', 'id')->where(function ($query) {
                $clientRoleId = Role::where('name', 'client')->first()->id;
                $query->where('role_id', $clientRoleId);
            })],
            'order_status_id' => 'required|exists:order_statuses,id', // Добавлено для валидации статуса
            'total_amount' => 'required|numeric|min:0', // Добавлено для валидации суммы
        ]);

        $order->update($validated);

        // Синхронизируем услуги (открепляет старые, прикрепляет новые)
        if ($request->has('services')) {
            $order->services()->sync($request->input('services'));
        } else {
            $order->services()->detach(); // Если услуги не выбраны, открепить все
        }

        return redirect()->route('orders.index')->with('success', 'Заказ успешно обновлен.');
    }

    public function destroy(Order $order)
    {
        $this->authorize('delete', $order);
        $order->delete();
        return redirect()->route('orders.index')->with('success', 'Заказ успешно удален.');
    }
}