<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerGroup extends Model
{
    protected $fillable = [
        'name',
        'tenant_id',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'customer_group_user', 'customer_group_id', 'user_id');
    }

    public function customPrices()
    {
        return $this->hasMany(GroupCustomPrice::class, 'customer_group_id');
    }
}
