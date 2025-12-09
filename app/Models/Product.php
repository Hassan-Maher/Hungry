<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = [
        'id'
    ];

    protected $hidden = ['created_at'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    
}
