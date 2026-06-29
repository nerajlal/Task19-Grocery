<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory, \App\Models\Traits\BelongsToTenant;

    protected $fillable = [
        'code',
        'type',
        'value',
        'status',
        'starts_at',
        'ends_at',
        'usage_limit',
        'uses_count',
        'tenant_id',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
    ];

    /**
     * Get the computed status based on dates.
     *
     * @return string
     */
    public function getComputedStatusAttribute()
    {
        if ($this->status !== 'active') {
            return $this->status;
        }

        $now = now();

        if ($this->starts_at > $now) {
            return 'scheduled';
        }

        if ($this->ends_at && $this->ends_at < $now) {
            return 'expired';
        }

        return 'active';
    }


    public function products()
    {
        return $this->belongsToMany(Product::class, 'discount_product');
    }
}
