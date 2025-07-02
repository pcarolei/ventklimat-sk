<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            // Изменено: фильтруем по user_id
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

        return view('orders.create', compact('services', 'clients'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Order::class);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'service_id' => 'required|exists:services,id',
            'user_id' => 'required|exists:users,id', // Изменено на user_id
            'status' => 'required|string',
        ]);

        // Если пользователь - клиент, то user_id должен быть его собственным ID
        if (Auth::user()->role->name === 'client') {
            $validated['user_id'] = Auth::id(); // Изменено на user_id
        }

        Order::create($validated);

        return redirect()->route('orders.index')->with('success', 'Заказ успешно создан.');
    }

    public function show(Order $order)
    {
        $this->authorize('view', $order);
        return view('orders.show', compact('order'));
    }

    public function edit(Order $order)
    {
        $this->authorize('update', $order);
        $services = Service::all();
        $clients = User::whereHas('role', function($query) {
            $query->where('name', 'client');
        })->get();
        return view('orders.edit', compact('order', 'services', 'clients'));
    }

    public function update(Request $request, Order $order)
    {
        $this->authorize('update', $order);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'service_id' => 'required|exists:services,id',
            'user_id' => 'required|exists:users,id', // Изменено на user_id
            'status' => 'required|string',
        ]);

        $order->update($validated);

        return redirect()->route('orders.index')->with('success', 'Заказ успешно обновлен.');
    }

    public function destroy(Order $order)
    {
        $this->authorize('delete', $order);
        $order->delete();
        return redirect()->route('orders.index')->with('success', 'Заказ успешно удален.');
    }
}