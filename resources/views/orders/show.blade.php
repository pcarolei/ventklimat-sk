<x-app-layout>
    <x-slot name="header">
        <h2 class="header-container-title">
            {{ __('Детали заказа №') }}{{ $order->id }}
        </h2>
    </x-slot>

    <div class="page-content">
        <div class="order-detail-card">
            <div class="detail-group">
                <span class="detail-label">ID Заказа:</span>
                <span class="detail-value">#{{ $order->id }}</span>
            </div>
            <div class="detail-group">
                <span class="detail-label">Статус:</span>
                <span class="detail-value status-{{ strtolower(str_replace(' ', '-', $order->orderStatus->name)) }}">
                    {{ $order->orderStatus->name }}
                </span>
            </div>
            <div class="detail-group">
                <span class="detail-label">Общая сумма:</span>
                <span class="detail-value">{{ number_format($order->total_amount, 2, ',', ' ') }} ₽</span>
            </div>
            <div class="detail-group">
                <span class="detail-label">Дата создания:</span>
                <span class="detail-value">{{ $order->created_at->format('d.m.Y H:i') }}</span>
            </div>
            <div class="detail-group detail-group-full">
                <span class="detail-label">Детали/Описание:</span>
                <span class="detail-value">{{ $order->details ?? 'Нет описания' }}</span>
            </div>
        </div>

        <div class="order-detail-card mt-6">
            <h3 class="card-title">Информация о клиенте</h3>
            <div class="detail-group">
                <span class="detail-label">Имя клиента:</span>
                <span class="detail-value">{{ $order->user->name ?? 'Неизвестно' }}</span>
            </div>
            <div class="detail-group">
                <span class="detail-label">Email клиента:</span>
                <span class="detail-value">{{ $order->user->email ?? 'Неизвестно' }}</span>
            </div>
        </div>

        {{-- Если у вас есть связь многие-ко-многим между orders и services через pivot-таблицу 'order_service' --}}
        {{-- Убедитесь, что эта связь определена в вашей модели Order и Service --}}
        @if ($order->services->isNotEmpty())
            <div class="order-detail-card mt-6">
                <h3 class="card-title">Оказанные услуги</h3>
                <table class="services-table"> {{-- Новый класс для таблицы услуг --}}
                    <thead>
                        <tr>
                            <th>Услуга</th>
                            <th>Описание</th>
                            <th>Цена</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->services as $service)
                            <tr>
                                <td>{{ $service->name }}</td>
                                <td>{{ $service->description }}</td>
                                <td>{{ number_format($service->price, 2, ',', ' ') }} ₽</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        <div class="mt-6">
            <a href="{{ route('orders.index') }}" class="back-button">
                &larr; Вернуться к списку заказов
            </a>
        </div>
    </div>
</x-app-layout>
