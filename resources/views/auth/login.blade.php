<x-guest-layout>
    <div class="login-container">
        <div class="login-header">
            <h1>Вход в CRM</h1>
            <p>Введите свои учетные данные</p>
        </div>

        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label for="email">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="Введите ваш email" required autofocus autocomplete="username" class="form-group-input">
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="form-group">
                <label for="password">Пароль</label>
                <input id="password" type="password" name="password" placeholder="Введите ваш пароль" required autocomplete="current-password" class="form-group-input">
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="form-group">
                <label for="remember_me">
                    <input id="remember_me" type="checkbox" name="remember">
                    <span>Запомнить меня</span>
                </label>
            </div>

            <div class="form-group">
                <button type="submit" class="login-button">Войти</button>
            </div>

            <div class="forgot-password">
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}">
                        Забыли пароль?
                    </a>
                @endif
            </div>
        </form>
    </div>
</x-guest-layout>