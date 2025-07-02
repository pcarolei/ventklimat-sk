<section>
    <header>
        <h2 class="section-title">
            {{ __('Обновить пароль') }}
        </h2>

        <p class="section-description">
            {{ __('Убедитесь, что ваша учетная запись использует длинный, случайный пароль, чтобы оставаться в безопасности.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div class="form-group">
            <label for="current_password">{{ __('Текущий пароль') }}</label>
            <input id="current_password" name="current_password" type="password" class="form-group-input" autocomplete="current-password">
            <x-input-error :messages="$errors->get('current_password')" class="mt-2" />
        </div>

        <div class="form-group">
            <label for="password">{{ __('Новый пароль') }}</label>
            <input id="password" name="password" type="password" class="form-group-input" autocomplete="new-password">
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="form-group">
            <label for="password_confirmation">{{ __('Подтвердите пароль') }}</label>
            <input id="password_confirmation" name="password_confirmation" type="password" class="form-group-input" autocomplete="new-password">
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="login-button">
                {{ __('Сохранить') }}
            </button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Сохранено.') }}</p>
            @endif
        </div>
    </form>
</section>