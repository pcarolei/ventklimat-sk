<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    use HasFactory;

    // Поля, разрешенные для массового присвоения
    protected $fillable = ['name'];

    /**
     * Получить заказы, имеющие этот статус.
     */
    public function orders()
    {
        // Указываем внешний ключ, если он не соответствует стандартному именованию (order_status_id)
        return $this->hasMany(Order::class, 'order_status_id');
    }
}