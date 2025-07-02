<x-app-layout>
    <x-slot name="header">
        <h2 class="header-container-title">
            {{ __('Дашборд') }}
        </h2>
    </x-slot>

    <div class="page-content">
        <div class="dashboard-stats-grid">
            {{-- Блок: Всего заказов --}}
            <div class="stat-card">
                <h3 class="stat-title">Всего заказов</h3>
                <p class="stat-value">{{ $totalOrders }}</p>
            </div>

            {{-- Блок: Новые заказы --}}
            <div class="stat-card stat-new">
                <h3 class="stat-title">Новые заказы</h3>
                <p class="stat-value">{{ $newOrders }}</p>
            </div>

            {{-- Блок: Заказы в работе --}}
            <div class="stat-card stat-processing">
                <h3 class="stat-title">В работе</h3>
                <p class="stat-value">{{ $processingOrders }}</p>
            </div>

            {{-- Блок: Завершенные заказы --}}
            <div class="stat-card stat-completed">
                <h3 class="stat-title">Завершенные</h3>
                <p class="stat-value">{{ $completedOrders }}</p>
            </div>

            {{-- Блок: Сумма за год --}}
            <div class="stat-card stat-amount">
                <h3 class="stat-title">Сумма за год</h3>
                <p class="stat-value">{{ number_format($lastYearAmount, 2, ',', ' ') }} ₽</p>
            </div>

            {{-- Блок: Всего клиентов --}}
            <div class="stat-card stat-clients">
                <h3 class="stat-title">Всего клиентов</h3>
                <p class="stat-value">{{ $totalClients }}</p>
            </div>

            {{-- Блок: Новые клиенты за месяц --}}
            <div class="stat-card stat-new-clients">
                <h3 class="stat-title">Новые клиенты (мес.)</h3>
                <p class="stat-value">{{ $newClientsLastMonth }}</p>
            </div>
        </div>

        <h3 class="section-title mt-8">Последние заказы</h3>
        <div class="recent-orders-table-wrapper">
            <table class="orders-table"> {{-- Используем тот же класс таблицы, что и для /orders --}}
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
                    @forelse($latestOrders as $order)
                    <tr>
                        <td>#{{ $order->id }}</td>
                        <td>{{ $order->user->name ?? 'N/A' }}</td>
                        <td>{{ $order->created_at->format('d.m.Y H:i') }}</td>
                        <td>{{ number_format($order->total_amount, 2, ',', ' ') }} ₽</td>
                        <td class="status-{{ strtolower(str_replace(' ', '-', $order->orderStatus->name)) }}">
                            {{ $order->orderStatus->name }}
                        </td>
                        <td><a href="{{ route('orders.index', ['id' => $order->id]) }}" class="view-order-button">Просмотр</a></td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">Нет последних заказов.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>