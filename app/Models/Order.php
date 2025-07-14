<?php

namespace App\Models;

use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    protected $guarded = ['id'];

    public function orderItems(){
        return $this->hasMany(OrderItem::class);
    }
}
