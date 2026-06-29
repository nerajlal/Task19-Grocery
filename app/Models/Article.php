<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory, \App\Models\Traits\BelongsToTenant;

    protected $fillable = ['title', 'slug', 'content', 'image', 'status', 'tenant_id'];
}
