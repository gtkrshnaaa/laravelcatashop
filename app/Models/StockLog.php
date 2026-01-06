<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockLog extends Model
{
    protected $fillable = [
        'product_id',
        'user_id',
        'old_stock',
        'new_stock',
        'reason',
    ];

    protected $casts = [
        'old_stock' => 'integer',
        'new_stock' => 'integer',
    ];

    /**
     * Get the product that owns the stock log.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the user who made the stock change.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the change amount (calculated).
     */
    public function getChangeAttribute()
    {
        return $this->new_stock - $this->old_stock;
    }
}
