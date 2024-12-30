<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = ['order_id', 'transaction_id', 'status', 'payment_type', 'transaction_time', 'status_code', 'gross_amount', 'midtrans_status', 'bank', 'snap_token'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
