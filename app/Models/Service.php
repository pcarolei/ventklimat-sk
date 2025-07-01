<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    // Поля, разрешенные для массового присвоения
    protected $fillable = ['name', 'description'];

    /**
     * Получить заказы, связанные с этой услугой.
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}