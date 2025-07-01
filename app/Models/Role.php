<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    // Поля, разрешенные для массового присвоения
    protected $fillable = ['name'];

    /**
     * Получить пользователей, принадлежащих этой роли.
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }
}