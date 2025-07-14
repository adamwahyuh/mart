<?php

namespace App\Models;

use App\Models\Cart;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    //
    protected $guarded = ['id'];

    public function cart(){
        return $this->belongsTo(Cart::class);
    }
}
