<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DosLog extends Model
{
    protected $fillable = [
        'ip_address',
        'accessed_at',
    ];
}
