<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $guarded = [
        'id'
    ];
    protected $hidden = ['updated_at'];

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function options()
    {
        return $this->hasMany(CartItemOption::class);
    }


    public function total_price()
    {
        $price = $this->price_of_product * $this->quantity;

        foreach($this->options as $option)
        {
            $price+= $option->price;
        }
        return $price;

    }




}
