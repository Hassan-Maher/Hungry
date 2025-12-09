<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = [
        'id'
    ];

    protected $hidden = ['created_at', 'updated_at'];


    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
