<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Панель заказов') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                {{-- Ваш HTML-код для панели заказов НАЧИНАЕТСЯ ЗДЕСЬ --}}
                <div class="container">
                    <h1>Панель заказов</h1>

                    <div class="filters">
                        <div class="filter-group">
                            <label for="date-filter">Дата</label>
                            <input type="date" id="date-filter">
                        </div>

                        <div class="filter-group">
                            <label for="status-filter">Статус</label>
                            <select id="status-filter">
                                <option value="all">Все</option>
                                <option value="new">Новые</option>
                                <option value="processing">В обработке</option>
                                <option value="completed">Завершённые</option>
                                <option value="cancelled">Отменённые</option>
                            </select>
                        </div>

                        <div class="filter-group">
                            <label for="search">Поиск</label>
                            <input type="text" id="search" placeholder="ID или клиент">
                        </div>
                    </div>

                    <table class="orders-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Клиент</th>
                                <th>Дата</th>
                                <th>Сумма</th>
                                <th>Статус</th>
                                <th>Действия</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Здесь будут выводиться реальные данные из БД --}}
                            @foreach(\App\Models\Order::all() as $order) {{-- Простой пример вывода данных --}}
                            <tr>
                                <td>#{{ $order->id }}</td>
                                <td>{{ $order->user->name ?? 'N/A' }}</td>
                                <td>{{ $order->created_at->format('d.m.Y') }}</td>
                                <td>{{ number_format($order->total_amount, 2, ',', ' ') }} ₽</td>
                                <td class="status-{{ strtolower($order->orderStatus->name) }}">
                                    {{ $order->orderStatus->name }}
                                </td>
                                <td><button>Просмотр</button></td>
                            </tr>
                            @endforeach
                            {{-- Конец примера вывода данных --}}
                        </tbody>
                    </table>
                </div>
                {{-- Ваш HTML-код для панели заказов ЗАКАНЧИВАЕТСЯ ЗДЕСЬ --}}

            </div>
        </div>
    </div>
</x-app-layout>