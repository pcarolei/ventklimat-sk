<x-app-layout>
        <x-slot name="header">
            <h2 class="header-container-title">
                {{ __('Заказы') }}
            </h2>
        </x-slot>

        <div class="page-content">
            {{-- Кнопка "Создать новый заказ" видна только администраторам и менеджерам --}}
            @if (Auth::user()->role->name === 'admin' || Auth::user()->role->name === 'manager')
                <div class="flex justify-end mb-4">
                    <a href="{{ route('orders.create') }}" class="create-button">
                        {{ __('Создать новый заказ') }}
                    </a>
                </div>
            @endif

            {{-- ... остальная часть вашего orders/index.blade.php ... --}}
            {{-- Например, таблица заказов --}}
            <div class="table-wrapper">
                <table class="orders-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Клиент</th>
                            <th>Дата</th>
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
                            <td class="status-{{ strtolower(str_replace(' ', '-', $order->orderStatus->name)) }}">
                                {{ $order->orderStatus->name }}
                            </td>
                            <td class="order-actions">
                                <a href="{{ route('orders.show', $order->id) }}" class="view-order-button">Просмотр</a>
                                {{-- Кнопки редактирования и удаления также должны быть защищены политиками --}}
                                @can('update', $order)
                                    <a href="{{ route('orders.edit', $order->id) }}" class="edit-order-button">Редактировать</a>
                                @endcan
                                @can('delete', $order)
                                    <form action="{{ route('orders.destroy', $order->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="delete-order-button" onclick="return confirm('Вы уверены, что хотите удалить этот заказ?');">Удалить</button>
                                    </form>
                                @endcan
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">Нет заказов.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </x-app-layout>
    