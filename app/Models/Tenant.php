<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    protected $fillable = [
        'name',
        'plan',
        'theme',
    ];

    public function admin()
    {
        return $this->hasOne(User::class, 'tenant_id')->where('type', 'admin');
    }
}
