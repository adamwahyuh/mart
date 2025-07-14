<?php

namespace App\Models;

use App\Models\Order;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    //
    protected $guarded = ['id'];

    public function order(){
        return $this->hasMany(Order::class);
    }
    public function product()
    {
        return $this->belongsTo(\App\Models\Product::class);
    }
}
