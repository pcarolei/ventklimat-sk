<x-app-layout>
    <x-slot name="header">
        <h2 class="header-container-title">
            {{ __('Редактировать заказ №') }}{{ $order->id }}
        </h2>
    </x-slot>

    <div class="page-content">
        <div class="form-card">
            <form method="POST" action="{{ route('orders.update', $order->id) }}">
                @csrf
                @method('PUT') {{-- Важно: используем метод PUT для обновления --}}

                {{-- Поле для выбора клиента (пользователя) --}}
                <div class="form-group">
                    <label for="user_id">{{ __('Клиент') }}</label>
                    <select id="user_id" name="user_id" class="form-group-input" required>
                        <option value="">Выберите клиента</option>
                        @foreach($clients as $client)
                            <option value="{{ $client->id }}" {{ old('user_id', $order->user_id) == $client->id ? 'selected' : '' }}>
                                {{ $client->name }} ({{ $client->email }})
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('user_id')" class="mt-2" />
                </div>

                {{-- Поле для выбора статуса заказа --}}
                <div class="form-group">
                    <label for="order_status_id">{{ __('Статус заказа') }}</label>
                    <select id="order_status_id" name="order_status_id" class="form-group-input" required>
                        <option value="">Выберите статус</option>
                        @foreach($orderStatuses as $status)
                            <option value="{{ $status->id }}" {{ old('order_status_id', $order->order_status_id) == $status->id ? 'selected' : '' }}>
                                {{ $status->name }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('order_status_id')" class="mt-2" />
                </div>

                {{-- Поле для общей суммы --}}
                <div class="form-group">
                    <label for="total_amount">{{ __('Общая сумма') }}</label>
                    <input id="total_amount" name="total_amount" type="number" step="0.01" min="0" class="form-group-input" value="{{ old('total_amount', $order->total_amount) }}" required>
                    <x-input-error :messages="$errors->get('total_amount')" class="mt-2" />
                </div>

                {{-- Поле для деталей/описания --}}
                <div class="form-group">
                    <label for="details">{{ __('Детали/Описание') }}</label>
                    <textarea id="details" name="details" class="form-group-input" rows="4">{{ old('details', $order->details) }}</textarea>
                    <x-input-error :messages="$errors->get('details')" class="mt-2" />
                </div>

                {{-- Поле для выбора услуг (многие-ко-многим) --}}
                <div class="form-group">
                    <label for="services">{{ __('Услуги') }}</label>
                    <select id="services" name="services[]" class="form-group-input" multiple>
                        @foreach($services as $service)
                            <option value="{{ $service->id }}"
                                {{ in_array($service->id, old('services', $order->services->pluck('id')->toArray())) ? 'selected' : '' }}>
                                {{ $service->name }} ({{ number_format($service->price, 2, ',', ' ') }} ₽)
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('services')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <a href="{{ route('orders.index') }}" class="secondary-button mr-3">
                        {{ __('Отмена') }}
                    </a>
                    <button type="submit" class="login-button">
                        {{ __('Сохранить изменения') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
