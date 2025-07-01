<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // Поля, разрешенные для массового присвоения
    protected $fillable = [
        'user_id',
        'service_id',
        'description',
        'order_status_id',
    ];

    /**
     * Получить пользователя, сделавшего заказ.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Получить услугу, к которой относится заказ.
     */
    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    /**
     * Получить статус заказа.
     */
    public function status()
    {
        // Указываем внешний ключ, если он не соответствует стандартному именованию (order_status_id)
        return $this->belongsTo(OrderStatus::class, 'order_status_id');
    }
}