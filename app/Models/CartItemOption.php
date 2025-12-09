<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItemOption extends Model
{
    protected $guarded = [
        'id'
    ];

    protected $hidden = ['created_at', 'updated_at'];

    public function cartItem()
    {
        return $this->belongsTo(CartItem::class);
    }

    public function optionable()
    {
        return $this->morphTo();
    }




}
