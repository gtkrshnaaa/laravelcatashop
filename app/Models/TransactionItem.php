<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransactionItem extends Model
{
    protected $fillable = [
        'transaction_id',
        'product_id',
        'product_snapshot',
        'quantity',
        'price_locked',
        'subtotal',
    ];

    protected $casts = [
        'product_snapshot' => 'array',
        'quantity' => 'integer',
        'price_locked' => 'decimal:0',
        'subtotal' => 'decimal:0',
    ];

    /**
     * Get the transaction that owns the item.
     */
    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class);
    }

    /**
     * Get the product that owns the item.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
