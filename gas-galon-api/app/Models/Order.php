<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    
    protected $fillable = [
        'customer_id',
        'driver_id',
        'order_detail_id',
        'order_date',
        'status',
        'total_price',
        'delivery_address',
    ];


    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function driver()
    {
        return $this->belongsTo(User::class, 'driver_id');
    }

    public function orderDetail()
    {
        return $this->belongsTo(OrderDetail::class, 'order_detail_id');
    }

    public function payment()
    {
        return $this->hasOne(Payment::class, 'order_id');
    }
}
