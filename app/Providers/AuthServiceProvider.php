<?php

namespace App\Providers;

use App\Models\Order;
use App\Policies\OrderPolicy;
use App\Models\Service;
use App\Policies\ServicePolicy;
use Illuminate\Support\Facades\Gate; // Возможно, уже импортировано
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Order::class => OrderPolicy::class,
        Service::class => ServicePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // Implicitly grant "super admin" role full permission
        // Это необязательный, но полезный шаг: администратор всегда имеет полный доступ.
        // Добавьте это в метод boot()
        // Важно: убедитесь, что у вас есть отношение 'role' на модели User
        // и что роль 'admin' существует.
        \Illuminate\Support\Facades\Gate::before(function ($user, $ability) {
            if ($user->role->name === 'admin') {
                return true;
            }
        });
    }
}