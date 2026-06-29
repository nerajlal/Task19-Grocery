<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TenantVideo extends Model
{
    use HasFactory, \App\Models\Traits\BelongsToTenant;

    protected $table = 'tenant_videos';

    protected $fillable = [
        'tenant_id',
        'video1_url',
        'video1_collection_id',
        'video2_url',
        'video2_collection_id',
        'video3_url',
        'video3_collection_id',
        'video4_url',
        'video4_collection_id',
        'video5_url',
        'video5_collection_id',
    ];

    public function video1Collection()
    {
        return $this->belongsTo(Collection::class, 'video1_collection_id');
    }

    public function video2Collection()
    {
        return $this->belongsTo(Collection::class, 'video2_collection_id');
    }

    public function video3Collection()
    {
        return $this->belongsTo(Collection::class, 'video3_collection_id');
    }

    public function video4Collection()
    {
        return $this->belongsTo(Collection::class, 'video4_collection_id');
    }

    public function video5Collection()
    {
        return $this->belongsTo(Collection::class, 'video5_collection_id');
    }
}
