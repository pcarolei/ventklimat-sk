<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use App\Models\OrderStatus;
use App\Models\Service;
use App\Models\Role; // Добавьте импорт модели Role
use Illuminate\Validation\Rule; // Добавьте импорт Rule

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user', 'orderStatus')->latest()->get();
        return view('orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load('user', 'orderStatus', 'services');
        return view('orders.show', compact('order'));
    }

    /**
     * Показывает форму для создания нового заказа.
     */
    public function create()
    {
        // Получаем только пользователей с ролью 'client' для выбора
        $clientRoleId = Role::where('name', 'client')->first()->id;
        $clients = User::where('role_id', $clientRoleId)->get(); // Получаем клиентов

        $orderStatuses = OrderStatus::all(); // Все статусы
        $services = Service::all(); // Все услуги

        return view('orders.create', compact('clients', 'orderStatuses', 'services'));
    }

    /**
     * Сохраняет новый заказ в базе данных.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => ['required', 'exists:users,id', Rule::exists('users', 'id')->where(function ($query) {
                $clientRoleId = Role::where('name', 'client')->first()->id;
                $query->where('role_id', $clientRoleId);
            })],
            'order_status_id' => 'required|exists:order_statuses,id',
            'total_amount' => 'required|numeric|min:0',
            'details' => 'nullable|string|max:1000',
            'services' => 'nullable|array',
            'services.*' => 'exists:services,id', // Каждое ID услуги должно существовать
        ]);

        $order = Order::create($request->only([
            'user_id', 'order_status_id', 'total_amount', 'details'
        ]));

        // Прикрепляем выбранные услуги
        if ($request->has('services')) {
            $order->services()->attach($request->input('services'));
        }

        return redirect()->route('orders.index')->with('success', 'Заказ успешно создан!');
    }

    /**
     * Показывает форму для редактирования существующего заказа.
     */
    public function edit(Order $order)
    {
        $clientRoleId = Role::where('name', 'client')->first()->id;
        $clients = User::where('role_id', $clientRoleId)->get();
        $orderStatuses = OrderStatus::all();
        $services = Service::all();

        // Загружаем прикрепленные услуги для предзаполнения формы
        $order->load('services');

        return view('orders.edit', compact('order', 'clients', 'orderStatuses', 'services'));
    }

    /**
     * Обновляет существующий заказ в базе данных.
     */
    public function update(Request $request, Order $order)
    {
        $request->validate([
            'user_id' => ['required', 'exists:users,id', Rule::exists('users', 'id')->where(function ($query) {
                $clientRoleId = Role::where('name', 'client')->first()->id;
                $query->where('role_id', $clientRoleId);
            })],
            'order_status_id' => 'required|exists:order_statuses,id',
            'total_amount' => 'required|numeric|min:0',
            'details' => 'nullable|string|max:1000',
            'services' => 'nullable|array',
            'services.*' => 'exists:services,id',
        ]);

        $order->update($request->only([
            'user_id', 'order_status_id', 'total_amount', 'details'
        ]));

        // Синхронизируем услуги (открепляет старые, прикрепляет новые)
        if ($request->has('services')) {
            $order->services()->sync($request->input('services'));
        } else {
            $order->services()->detach(); // Если услуги не выбраны, открепить все
        }

        return redirect()->route('orders.index')->with('success', 'Заказ успешно обновлен!');
    }

    /**
     * Удаляет заказ из базы данных.
     */
    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('orders.index')->with('success', 'Заказ успешно удален!');
    }
}