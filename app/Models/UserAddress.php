<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class UserAddress extends Model
{
    /** @use HasFactory<\Database\Factories\UserAddressFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'phone',
        'address_line1',
        'address_line2',
        'city',
        'state',
        'zip',
        'country',
        'is_default',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
