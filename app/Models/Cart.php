<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $guarded = [
        'id'
    ];

    protected $hidden = ['created_at', 'updated_at'];

    public function items()
    {
        return $this->hasMany(CartItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function price()
    {
        $price = 0;
        foreach($this->items as $item)
        {
            $price+= $item->total_price;
        }
        return $price;
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }
}
