<x-app-layout>
    <x-slot name="header">
        <h2 class="header-container-title">
            {{ __('Управление услугами') }}
        </h2>
    </x-slot>

    <div class="page-content">
        <div class="flex justify-end mb-4">
            <a href="{{ route('services.create') }}" class="create-button">
                {{ __('Создать новую услугу') }}
            </a>
        </div>

        <div class="table-wrapper"> {{-- Переименовал в table-wrapper для общего использования --}}
            <table class="data-table"> {{-- Новый класс для таблицы услуг --}}
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Название</th>
                        <th>Описание</th>
                        <th>Цена</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($services as $service)
                    <tr>
                        <td>{{ $service->id }}</td>
                        <td>{{ $service->name }}</td>
                        <td>{{ $service->description ?? 'Нет описания' }}</td>
                        <td>{{ number_format($service->price, 2, ',', ' ') }} ₽</td>
                        <td class="action-buttons-cell"> {{-- Класс для ячейки с кнопками действий --}}
                            <a href="{{ route('services.edit', $service->id) }}" class="edit-button">Редактировать</a>
                            <form action="{{ route('services.destroy', $service->id) }}" method="POST" onsubmit="return confirm('Вы уверены, что хотите удалить эту услугу?');" style="display:inline-block; margin-left: 5px;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="delete-button">Удалить</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">Нет услуг.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
