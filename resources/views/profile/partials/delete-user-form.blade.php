<section class="space-y-6">
    <header>
        <h2 class="section-title">
            {{ __('Удалить аккаунт') }}
        </h2>

        <p class="section-description">
            {{ __('Как только ваш аккаунт будет удален, все его ресурсы и данные будут безвозвратно удалены. Пожалуйста, введите свой пароль, чтобы подтвердить, что вы хотите навсегда удалить свою учетную запись.') }}
        </p>
    </header>

    <button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="delete-button" {{-- Новый класс для кнопки удаления --}}
    >{{ __('Удалить аккаунт') }}</button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="modal-title">
                {{ __('Вы уверены, что хотите удалить свой аккаунт?') }}
            </h2>

            <p class="modal-description">
                {{ __('Как только ваш аккаунт будет удален, все его ресурсы и данные будут безвозвратно удалены. Пожалуйста, введите свой пароль, чтобы подтвердить, что вы хотите навсегда удалить свою учетную запись.') }}
            </p>

            <div class="form-group mt-6">
                <label for="password_delete">{{ __('Пароль') }}</label>
                <input id="password_delete" name="password" type="password" class="form-group-input" placeholder="{{ __('Пароль') }}">
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <button type="button" x-on:click="$dispatch('close')" class="secondary-button">
                    {{ __('Отмена') }}
                </button>

                <button type="submit" class="delete-button ml-3">
                    {{ __('Удалить аккаунт') }}
                </button>
            </div>
        </form>
    </x-modal>
</section>