<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transaction extends Model
{
    protected $fillable = [
        'customer_id',
        'invoice_code',
        'customer_info',
        'payment_method',
        'unique_code',
        'amount_subtotal',
        'amount_total',
        'status',
        'status_history',
        'notes',
        'paid_at',
        'shipped_at',
        'completed_at',
    ];

    protected $casts = [
        'customer_info' => 'array',
        'status_history' => 'array',
        'amount_subtotal' => 'decimal:0',
        'amount_total' => 'decimal:0',
        'paid_at' => 'datetime',
        'shipped_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    /**
     * Get the transaction items for the transaction.
     */
    public function items(): HasMany
    {
        return $this->hasMany(TransactionItem::class);
    }

    /**
     * Get the customer that owns the transaction.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Scope a query to filter by status.
     */
    public function scopeByStatus(Builder $query, string $status): void
    {
        $query->where('status', $status);
    }

    /**
     * Scope a query to only include pending transactions.
     */
    public function scopePending(Builder $query): void
    {
        $query->where('status', 'unpaid');
    }

    /**
     * Scope a query to only include paid transactions.
     */
    public function scopePaid(Builder $query): void
    {
        $query->where('status', 'paid');
    }

    /**
     * Change transaction status with audit trail.
     */
    public function changeStatus(string $newStatus, string $changedBy = 'System'): void
    {
        $oldStatus = $this->status;

        // Update status
        $this->status = $newStatus;

        // Add to audit trail
        $history = $this->status_history ?? [];
        $history[] = [
            'from' => $oldStatus,
            'to' => $newStatus,
            'changed_at' => now()->toDateTimeString(),
            'changed_by' => $changedBy,
        ];
        $this->status_history = $history;

        // Set timestamp based on status
        if ($newStatus === 'paid') {
            $this->paid_at = now();
        } elseif ($newStatus === 'shipped') {
            $this->shipped_at = now();
        } elseif ($newStatus === 'completed') {
            $this->completed_at = now();
        }

        $this->save();
    }
}
