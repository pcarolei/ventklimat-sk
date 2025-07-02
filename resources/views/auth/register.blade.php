<x-guest-layout>
    <div class="login-container"> {{-- Используем тот же контейнер, что и для логина --}}
        <div class="login-header">
            <h1>Регистрация</h1>
            <p>Создайте новый аккаунт</p>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="form-group">
                <label for="name">Имя</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" placeholder="Введите ваше имя" required autofocus autocomplete="name" class="form-group-input">
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="Введите ваш email" required autocomplete="username" class="form-group-input">
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="form-group">
                <label for="password">Пароль</label>
                <input id="password" type="password" name="password" placeholder="Введите ваш пароль" required autocomplete="new-password" class="form-group-input">
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="form-group">
                <label for="password_confirmation">Подтвердите пароль</label>
                <input id="password_confirmation" type="password" name="password_confirmation" placeholder="Повторите пароль" required autocomplete="new-password" class="form-group-input">
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <div class="form-group">
                <button type="submit" class="login-button">
                    Зарегистрироваться
                </button>
            </div>

            <div class="forgot-password"> {{-- Используем тот же класс для ссылки на вход --}}
                <a href="{{ route('login') }}">
                    Уже зарегистрированы?
                </a>
            </div>
        </form>
    </div>
</x-guest-layout>