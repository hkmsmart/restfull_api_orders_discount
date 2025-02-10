<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    protected $fillable = ['name','category','price','stock','description'];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
