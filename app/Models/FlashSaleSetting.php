<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FlashSaleSetting extends Model
{
    protected $fillable = [
        'is_active',
        'title',
        'badge_text',
        'description',
        'weekly_limit',
        'reset_day',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'weekly_limit' => 'integer',
    ];

    /**
     * Get the singleton settings instance
     */
    public static function getSettings()
    {
        return static::firstOrCreate([], [
            'is_active' => true,
            'title' => 'Weekly Special Offer',
            'badge_text' => 'Flash Sale Ends Soon',
            'description' => 'Don\'t miss out on our limited time deals. Prices reset every Monday!',
            'weekly_limit' => 50,
            'reset_day' => 'monday',
        ]);
    }

    /**
     * Calculate used slots and remaining slots
     */
    public function getSlotStats()
    {
        $usedSlots = \App\Models\Transaction::whereBetween('created_at', [
            now()->startOfWeek(),
            now()->endOfWeek()
        ])->count();

        $slotsRemaining = max(0, $this->weekly_limit - $usedSlots);

        return [
            'used' => $usedSlots,
            'remaining' => $slotsRemaining,
            'total' => $this->weekly_limit,
            'percentage' => $this->weekly_limit > 0 ? ($usedSlots / $this->weekly_limit) * 100 : 0,
        ];
    }
}
