<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class OrderItemOption extends Model
{
    protected $guarded = [
        'id'
    ];

    public function orderItem()
    {
        return $this->belongsTo(OrderItem::class);
    }

    public function optionable()
    {
        return $this->morphTo();
    }
}
