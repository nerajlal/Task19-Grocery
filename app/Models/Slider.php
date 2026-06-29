<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory, \App\Models\Traits\BelongsToTenant;

    protected $fillable = [
        'image_desktop',
        'image_mobile',
        'title',
        'status',
        'order',
        'tenant_id',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];
}
