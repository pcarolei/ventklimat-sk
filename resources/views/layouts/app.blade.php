<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        {{-- Основная навигационная панель (шапка сайта) --}}
        <nav class="main-nav">
            <div class="nav-container">
                {{-- Логотип / Название сайта --}}
                <div class="nav-logo">
                    <a href="{{ route('dashboard') }}">
                        ВЕНТКЛИМАТ-СК CRM
                    </a>
                </div>

                {{-- Основные ссылки навигации --}}
                <div class="nav-links">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        Главная
                    </a>
                    <a href="{{ route('orders.index') }}" class="nav-link {{ request()->routeIs('orders.index') ? 'active' : '' }}">
                        Заказы
                    </a>
                    <a href="{{ route('services.index') }}" class="nav-link {{ request()->routeIs('services.index') ? 'active' : '' }}"> {{-- Добавьте эту строку --}}
                        Услуги
                    </a>
                    {{-- Добавьте другие ссылки по необходимости --}}
                </div>

                {{-- Выпадающее меню пользователя --}}
                <div class="nav-user-menu">
                    <div class="user-info">
                        {{ Auth::user()->name }}
                    </div>
                    <div class="user-dropdown">
                        <a href="{{ route('profile.edit') }}" class="dropdown-item">Профиль</a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a href="{{ route('logout') }}"
                               onclick="event.preventDefault(); this.closest('form').submit();"
                               class="dropdown-item">
                                Выйти
                            </a>
                        </form>
                    </div>
                </div>

                {{-- Кнопка для мобильной навигации (пока без JS) --}}
                <button class="menu-toggle">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
            </div>

            {{-- Мобильная навигация (скрыта по умолчанию, потребует JS для toggle) --}}
            <div class="responsive-nav">
                <a href="{{ route('dashboard') }}" class="responsive-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">Главная</a>
                <a href="{{ route('orders.index') }}" class="responsive-link {{ request()->routeIs('orders.index') ? 'active' : '' }}">Заказы</a>
                <a href="{{ route('profile.edit') }}" class="responsive-link">Профиль</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a href="{{ route('logout') }}"
                       onclick="event.preventDefault(); this.closest('form').submit();"
                       class="responsive-link">
                        Выйти
                    </a>
                </form>
            </div>
        </nav>

        {{-- Заголовок страницы (если есть) --}}
        @if (isset($header))
            <header class="page-header">
                <div class="header-container">
                    {{ $header }}
                </div>
            </header>
        @endif

        {{-- Основное содержимое страницы --}}
        <main class="page-content">
            {{ $slot }}
        </main>
    </div>
</body>
</html>