<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory,  HasUuids;

    // protected $fillable = ['user_id', 'price', 'status', 'shipping_address', 'shipping_method', 'shipping_cost', 'phone_number', 'midtrans_order_id', 'midtrans_status'];
    protected $fillable = ['user_id', 'total_order_price', 'total_product_price', 'status', 'discount_code', 'discount_amount'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            $order->expired_at = now()->addMinutes(60);
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function order_items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function shipping()
    {
        return $this->hasOne(Shipping::class);
    }

    public function discount()
    {
        return $this->belongsTo(Discount::class, 'discount_code', 'code');
    }
}
