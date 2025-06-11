<?php

namespace App\Models;

use App\Models\User;
use App\Models\Price;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = ['id'];


    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function price(){
        return $this->hasOne(Price::class); 
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
