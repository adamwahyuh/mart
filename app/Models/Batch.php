<?php

namespace App\Models;

use App\Models\Product;
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

    public function scopeSearch($query, $term)
    {
        if (!$term) {
            return $query;
        }

        $keywords = explode(' ', $term);

        return $query->where(function ($q) use ($keywords) {
            foreach ($keywords as $word) {
                $q->orWhere('batch_code', 'LIKE', "%$word%")
                    ->orWhereHas('product', function ($q2) use ($word) {
                        $q2->where('name', 'LIKE', "%$word%");
                    })
                    ->orWhereHas('movements', function ($q3) use ($word) {
                        $q3->where('type', 'LIKE', "%$word%");
                    })
                    ->orWhereDate('prdouction_date', 'LIKE', "%$word%")
                    ->orWhereDate('expired', 'LIKE', "%$word%")
                    ->orWhereYear('created_at', $word)
                    ->orWhereMonth('created_at', $word);
            }
        });
    }

}
