<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class User extends Model
{
    protected $table = 'users';

    protected $fillable = [
        'first_name',
        'last_name',
        'document',
        'email',
        'phone_number',
        'birth_date',
    ];

    /**
     * relationship with orders
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
