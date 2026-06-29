<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeProduct extends Model
{
    use \App\Models\Traits\BelongsToTenant;

    protected $fillable = ['product_id', 'sort_order', 'tenant_id'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
