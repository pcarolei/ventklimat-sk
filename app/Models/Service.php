<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description', // Добавлено
        'price',       // Добавлено
    ];

    // Если у вас будут заказы, связанные с услугами, здесь можно добавить отношение:
    public function orders()
    {
        return $this->hasMany(Order::class); // Если связь 1-ко-многим
        // return $this->belongsToMany(Order::class, 'order_service', 'service_id', 'order_id'); // Если связь многие-ко-многим
    }
}