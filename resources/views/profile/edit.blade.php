<x-app-layout>
    <x-slot name="header">
        <h2 class="header-container-title"> {{-- Используем класс из app.blade.php для заголовка --}}
            {{ __('Профиль') }}
        </h2>
    </x-slot>

    <div class="page-content"> {{-- Используем класс из app.blade.php для основного контента --}}
        <div class="profile-section-container"> {{-- Новый контейнер для секций профиля --}}
            <div class="profile-section-card"> {{-- Карточка для каждой секции --}}
                @include('profile.partials.update-profile-information-form')
            </div>

            <div class="profile-section-card">
                @include('profile.partials.update-password-form')
            </div>

            <div class="profile-section-card">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</x-app-layout>