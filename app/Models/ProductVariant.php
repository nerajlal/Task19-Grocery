<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'size',
        'price',
        'compare_at_price',
        'stock',
        'sku',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function getPriceAttribute($value)
    {
        if (auth()->check()) {
            $custom = \App\Models\CustomPrice::where('user_id', auth()->id())
                ->where('product_id', $this->product_id)
                ->first();
            if ($custom) {
                return $custom->price;
            }
        }
        return $value;
    }
}
