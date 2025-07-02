<x-app-layout>
    <x-slot name="header">
        <h2 class="header-container-title">
            {{ __('Создать новую услугу') }}
        </h2>
    </x-slot>

    <div class="page-content">
        <div class="form-card">
            <form method="POST" action="{{ route('services.store') }}">
                @csrf

                <div class="form-group">
                    <label for="name">{{ __('Название услуги') }}</label>
                    <input id="name" name="name" type="text" class="form-group-input" value="{{ old('name') }}" required autofocus>
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <div class="form-group">
                    <label for="description">{{ __('Описание услуги') }}</label>
                    <textarea id="description" name="description" class="form-group-input" rows="4">{{ old('description') }}</textarea>
                    <x-input-error :messages="$errors->get('description')" class="mt-2" />
                </div>

                <div class="form-group">
                    <label for="price">{{ __('Цена') }}</label>
                    <input id="price" name="price" type="number" step="0.01" min="0" class="form-group-input" value="{{ old('price') }}" required>
                    <x-input-error :messages="$errors->get('price')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <a href="{{ route('services.index') }}" class="secondary-button mr-3">
                        {{ __('Отмена') }}
                    </a>
                    <button type="submit" class="login-button">
                        {{ __('Создать услугу') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
