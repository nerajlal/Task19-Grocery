<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CustomPrice extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory, \App\Models\Traits\BelongsToTenant;

    protected $fillable = [
        'user_id',
        'product_id',
        'price',
        'tenant_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
