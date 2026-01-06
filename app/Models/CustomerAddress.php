<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerAddress extends Model
{
    protected $fillable = [
        'customer_id',
        'label',
        'address',
        'is_default',
    ];

    protected $casts = [
        'is_default' => 'boolean',
    ];

    /**
     * Get the customer that owns the address.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * The "booted" method of the model.
     */
    protected static function booted()
    {
        static::saving(function ($address) {
            if ($address->is_default) {
                // Unset other default addresses for this customer
                static::where('customer_id', $address->customer_id)
                    ->where('id', '!=', $address->id ?? 0)
                    ->update(['is_default' => false]);
            }
        });
    }
}
