<x-app-layout>
    <x-slot name="header">
        <h2 class="header-container-title">
            {{ __('Панель заказов') }}
        </h2>
    </x-slot>

    <div class="page-content">
        <div class="flex justify-end mb-4"> {{-- Добавляем flex-контейнер для кнопки --}}
            <a href="{{ route('orders.create') }}" class="create-button"> {{-- Новый класс для кнопки --}}
                {{ __('Создать новый заказ') }}
            </a>
        </div>

        <div class="orders-table-wrapper">
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
                    @forelse($orders as $order)
                    <tr>
                        <td>#{{ $order->id }}</td>
                        <td>{{ $order->user->name ?? 'N/A' }}</td>
                        <td>{{ $order->created_at->format('d.m.Y H:i') }}</td>
                        <td>{{ number_format($order->total_amount, 2, ',', ' ') }} ₽</td>
                        <td class="status-{{ strtolower(str_replace(' ', '-', $order->orderStatus->name)) }}">
                            {{ $order->orderStatus->name }}
                        </td>
                        <td class="order-actions"> {{-- Новый класс для ячейки с действиями --}}
                            <a href="{{ route('orders.show', $order->id) }}" class="view-order-button">Просмотр</a>
                            <a href="{{ route('orders.edit', $order->id) }}" class="edit-order-button">Редактировать</a> {{-- Кнопка редактирования --}}
                            <form action="{{ route('orders.destroy', $order->id) }}" method="POST" onsubmit="return confirm('Вы уверены, что хотите удалить этот заказ?');" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="delete-order-button">Удалить</button> {{-- Кнопка удаления --}}
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">Нет заказов.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>