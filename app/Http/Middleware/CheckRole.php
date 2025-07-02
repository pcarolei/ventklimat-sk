<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            // Если пользователь не авторизован, перенаправляем на страницу входа
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Если у пользователя нет роли или его роль отсутствует в списке разрешенных
        if (!$user->role || !in_array($user->role->name, $roles)) {
            // Вы можете перенаправить его на дашборд с ошибкой
            // или выдать 403 Forbidden ошибку
            abort(403, 'У вас нет прав для доступа к этой странице.');
        }

        return $next($request);
    }
}