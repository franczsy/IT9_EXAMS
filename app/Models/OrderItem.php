<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = ['order_id', 'rice_item_id', 'quantity_kg', 'price_per_kg_at_time', 'subtotal'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function riceItem()
    {
        return $this->belongsTo(RiceItem::class);
    }
}