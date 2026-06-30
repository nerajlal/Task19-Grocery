<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupCustomPrice extends Model
{
    protected $fillable = [
        'customer_group_id',
        'product_id',
        'price',
        'tenant_id',
    ];

    public function group()
    {
        return $this->belongsTo(CustomerGroup::class, 'customer_group_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
