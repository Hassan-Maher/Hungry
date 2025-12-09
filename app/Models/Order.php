<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = [
        'id'
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
    public function user()
    {
        return $this->belongsTo(user::class);
    }

     public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

}
