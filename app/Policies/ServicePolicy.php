<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Service;
use App\Models\Role; // Важно: убедитесь, что App\Models\Role импортирована
use Illuminate\Auth\Access\Response; // Важно: убедитесь, что Illuminate\Auth\Access\Response импортирована

class ServicePolicy
{
    // Метод 'before' позволит администратору обходить все проверки политик
    public function before(User $user, string $ability): ?bool
    {
        // Если у пользователя роль 'admin', разрешаем любое действие.
        if ($user->role->name === 'admin') {
            return true;
        }

        // Если это не админ, продолжаем обычную проверку политики.
        return null;
    }

    /**
     * Determine whether the user can view any models.
     * Просмотр списка услуг.
     * Доступно всем авторизованным пользователям.
     */
    public function viewAny(User $user): Response
    {
        // Админ уже обработан в before()
        // Всем остальным авторизованным пользователям разрешаем просмотр списка услуг.
        return $user->id !== null
               ? Response::allow()
               : Response::deny('Вы должны быть авторизованы для просмотра услуг.');
    }

    /**
     * Determine whether the user can view the model.
     * Просмотр конкретной услуги.
     * Доступно всем авторизованным пользователям.
     */
    public function view(User $user, Service $service): Response
    {
        // Админ уже обработан в before()
        // Всем остальным авторизованным пользователям разрешаем просмотр конкретной услуги.
        return $user->id !== null
               ? Response::allow()
               : Response::deny('Вы должны быть авторизованы для просмотра этой услуги.');
    }

    /**
     * Determine whether the user can create models.
     * Создание услуги.
     * Только менеджер может создавать услуги.
     */
    public function create(User $user): Response
    {
        // Админ уже обработан в before()
        return $user->role->name === 'manager'
               ? Response::allow()
               : Response::deny('У вас нет прав для создания услуг.');
    }

    /**
     * Determine whether the user can update the model.
     * Изменение услуги.
     * Только менеджер может изменять услуги.
     */
    public function update(User $user, Service $service): Response
    {
        // Админ уже обработан в before()
        return $user->role->name === 'manager'
               ? Response::allow()
               : Response::deny('У вас нет прав для изменения этой услуги.');
    }

    /**
     * Determine whether the user can delete the model.
     * Удаление услуги.
     * Только администратор (уже обработан в before()).
     */
    public function delete(User $user, Service $service): Response
    {
        // Админ уже обработан в before()
        return Response::deny('У вас нет прав для удаления этой услуги.');
    }

    /**
     * Determine whether the user can restore the model.
     * Восстановление удаленной услуги.
     * Только администратор (уже обработан в before()).
     */
    public function restore(User $user, Service $service): Response
    {
        // Админ уже обработан в before()
        return Response::deny('У вас нет прав для восстановления этой услуги.');
    }

    /**
     * Determine whether the user can permanently delete the model.
     * Окончательное удаление услуги.
     * Только администратор (уже обработан в before()).
     */
    public function forceDelete(User $user, Service $service): Response
    {
        // Админ уже обработан в before()
        return Response::deny('У вас нет прав для окончательного удаления этой услуги.');
    }
}