<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View; // Импорт View

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = Auth::user(); // Получаем текущего авторизованного пользователя

        // Если пользователь - администратор или менеджер, на дашборд
        if ($user->role->name === 'admin' || $user->role->name === 'manager') {
            return redirect()->intended(route('dashboard', absolute: false));
        }
        // Если пользователь - клиент, на страницу заказов
        elseif ($user->role->name === 'client') {
            return redirect()->intended(route('orders.index', absolute: false));
        }

        // Fallback для других ролей или если роль не определена
        return redirect()->intended(RouteServiceProvider::HOME); // Можно перенаправить на welcome или другую страницу
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}