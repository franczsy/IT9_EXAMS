<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiceItem extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'price_per_kg', 'stock_quantity', 'description'];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}