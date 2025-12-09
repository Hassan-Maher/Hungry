<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $guarded = [
        'id'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }


    public function options()
    {
        return $this->hasMany(OrderItemOption::class);
    }

        public function product()
    {
        return $this->belongsTo(Product::class);
    }

}
