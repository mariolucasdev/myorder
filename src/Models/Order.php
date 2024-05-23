<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    protected $table = 'orders';
    protected $fillable = ['user_id', 'description',  'quantity', 'price'];

    /**
     * relationship with user
     *
     * @return void
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * get total attribute
     *
     * @return void
     */
    public function getTotalAttribute(): float
    {
        return $this->quantity * $this->price;
    }
}