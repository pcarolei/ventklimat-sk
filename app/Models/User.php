<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Поля, разрешенные для массового присвоения
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id', // Добавляем role_id
    ];

    // Поля, которые должны быть скрыты при сериализации
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Типы приведения (casts) для атрибутов
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Получить роль, к которой принадлежит пользователь.
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Получить заказы, сделанные пользователем.
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}