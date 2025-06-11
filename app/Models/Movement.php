<?php

namespace App\Models;

use App\Models\User;
use App\Models\Batch;
use App\Models\Vendor;
use Illuminate\Database\Eloquent\Model;

class Movement extends Model
{
    protected $guarded = ['id'];


    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
