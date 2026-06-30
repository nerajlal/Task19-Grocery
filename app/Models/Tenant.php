<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    protected $fillable = [
        'name',
        'plan',
        'theme',
        'about_title',
        'about_text',
        'contact_email',
        'contact_phone',
        'contact_address',
        'shipping_policy',
        'return_policy',
        'terms_of_service',
    ];

    public function admin()
    {
        return $this->hasOne(User::class, 'tenant_id')->where('type', 'admin');
    }
}
