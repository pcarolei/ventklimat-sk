<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Order;
use App\Models\Role;
use Illuminate\Auth\Access\Response;

class OrderPolicy
{
    public function before(User $user, string $ability): ?bool
    {
        if ($user->role->name === 'admin') {
            return true;
        }
        return null;
    }

    public function viewAny(User $user): Response
    {
        return $user->id !== null
               ? Response::allow()
               : Response::deny('Вы должны быть авторизованы для просмотра этой страницы.');
    }

    public function view(User $user, Order $order): Response
    {
        if ($user->role->name === 'manager') {
            return Response::allow();
        }
        if ($user->role->name === 'client' && $user->id === $order->user_id) {
            return Response::allow();
        }
        return Response::deny('У вас нет прав для просмотра этого заказа.');
    }

    /**
     * Determine whether the user can create models.
     * Создание заказа.
     * Разрешено только администраторам и менеджерам.
     */
    public function create(User $user): Response
    {
        // Админ уже обработан в before()
        return $user->role->name === 'manager' // <-- Изменено: только менеджеры могут создавать
               ? Response::allow()
               : Response::deny('У вас нет прав для создания заказа.');
    }

    public function update(User $user, Order $order): Response
    {
        return $user->role->name === 'manager'
               ? Response::allow()
               : Response::deny('У вас нет прав для изменения этого заказа.');
    }

    public function delete(User $user, Order $order): Response
    {
        return Response::deny('У вас нет прав для удаления этого заказа.');
    }

    public function restore(User $user, Order $order): Response
    {
        return Response::deny('У вас нет прав для восстановления этого заказа.');
    }

    public function forceDelete(User $user, Order $order): Response
    {
        return Response::deny('У вас нет прав для окончательного удаления этого заказа.');
    }
}