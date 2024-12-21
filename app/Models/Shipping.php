<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
    protected $fillable = ['order_id', 'province_id', 'city_id', 'address', 'cost', 'courier_name', 'courier_code', 'courier_service', 'courier_service_description', 'estimate_day', 'tracking_number'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function province()
    {
        return $this->belongsTo(Province::class)->withDefault();
    }

    public function city()
    {
        return $this->belongsTo(City::class)->withDefault();
    }
}
