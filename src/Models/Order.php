<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class Order extends Model
{
    protected $table = 'orders';

    protected $fillable = ['user_id', 'description',  'quantity', 'price'];

    /**
     * relationship with user
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * get total attribute
     *
     * @return float
     */
    public function getTotalAttribute(): float
    {
        /* @phpstan-ignore-next-line */
        return $this->quantity * $this->price;
    }
}
