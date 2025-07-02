<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // Импортируем BelongsTo

class Order extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'order_status_id',
        'total_amount',
        'details',
        'service_id', // Если у вас есть service_id в таблице orders
    ];

    /**
     * Get the user that owns the Order.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the order status that owns the Order.
     */
    public function orderStatus(): BelongsTo
    {
        return $this->belongsTo(OrderStatus::class);
    }

    // Если у вас есть связь с услугами:
    public function service(): BelongsTo // Если связь 1-ко-многим через service_id
    {
        return $this->belongsTo(Service::class);
    }
}