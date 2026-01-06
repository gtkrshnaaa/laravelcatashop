<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductReview extends Model
{
    protected $fillable = [
        'product_id',
        'customer_id',
        'guest_name',
        'rating',
        'review',
        'images',
        'helpful_count',
        'status',
    ];

    protected $casts = [
        'images' => 'array',
        'helpful_count' => 'integer',
        'rating' => 'integer',
    ];

    /**
     * Get the product that owns the review.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the customer that wrote the review.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Scope to only approved reviews.
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * Scope to pending reviews.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Get reviewer name (customer or guest).
     */
    public function getReviewerNameAttribute()
    {
        return $this->customer ? $this->customer->name : $this->guest_name;
    }
}
