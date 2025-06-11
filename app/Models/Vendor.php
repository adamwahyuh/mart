<?php

namespace App\Models;

use App\Models\Movement;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    protected $guarded = ['id'];

    public function movement()
    {
        return $this->hasMany(Movement::class);
    }
}
