<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order; // Добавьте импорт
use Illuminate\Database\Eloquent\Relations\BelongsToMany; // Добавьте импорт

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

    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class, 'order_service', 'service_id', 'order_id');
    }
}