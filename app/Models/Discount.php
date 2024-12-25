<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    protected $fillable = ['code', 'name', 'description', 'amount', 'percentage', 'type', 'start_date', 'end_date', 'is_active', 'claim_limit', 'claimed'];

    public function orders()
    {
        return $this->hasMany(Order::class, 'discount_code', 'code');
    }
}
