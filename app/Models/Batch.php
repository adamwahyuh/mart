<?php

namespace App\Models;

use App\Models\Movement;
use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    protected $guarded = ['id'];

    public function movements()
    {
        return $this->hasMany(Movement::class);
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }   
}
