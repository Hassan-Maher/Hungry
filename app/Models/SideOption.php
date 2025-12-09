<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SideOption extends Model
{
    protected $guarded = [
        'id'
    ];

    protected $hidden = ['created_at' , 'updated_at'];
    
    public function cart_options() 
    {
        return $this->morphMany(CartItemOption::class, 'optionable');
    }
    public function order_options()
    {
        return $this->morphMany(OrderItemOption::class, 'optionable');
    }
}
