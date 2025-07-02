<x-app-layout>
    <x-slot name="header">
        <h2 class="header-container-title">
            {{ __('Детали услуги: ') }}{{ $service->name }}
        </h2>
    </x-slot>

    <div class="page-content">
        <div class="order-detail-card"> {{-- Используем тот же класс, что и для деталей заказа --}}
            <div class="detail-group">
                <span class="detail-label">ID Услуги:</span>
                <span class="detail-value">{{ $service->id }}</span>
            </div>
            <div class="detail-group">
                <span class="detail-label">Название:</span>
                <span class="detail-value">{{ $service->name }}</span>
            </div>
            <div class="detail-group">
                <span class="detail-label">Цена:</span>
                <span class="detail-value">{{ number_format($service->price, 2, ',', ' ') }} ₽</span>
            </div>
            <div class="detail-group detail-group-full">
                <span class="detail-label">Описание:</span>
                <span class="detail-value">{{ $service->description ?? 'Нет описания' }}</span>
            </div>
        </div>

        <div class="mt-6">
            <a href="{{ route('services.index') }}" class="back-button">
                &larr; Вернуться к списку услуг
            </a>
            <a href="{{ route('services.edit', $service->id) }}" class="edit-button ml-3">
                Редактировать услугу
            </a>
        </div>
    </div>
</x-app-layout>
