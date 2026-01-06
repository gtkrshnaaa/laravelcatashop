<?php

namespace Database\Seeders;

use App\Models\Coupon;
use Illuminate\Database\Seeder;

class CouponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $coupons = [
            [
                'code' => 'WELCOME10',
                'type' => 'percentage',
                'value' => 10.00,
                'min_amount' => 100000.00,
                'max_uses' => 100,
                'used_count' => 5,
                'expires_at' => now()->addMonths(3),
                'is_active' => true,
            ],
            [
                'code' => 'NEWYEAR2026',
                'type' => 'percentage',
                'value' => 25.00,
                'min_amount' => 250000.00,
                'max_uses' => 50,
                'used_count' => 12,
                'expires_at' => now()->addMonth(),
                'is_active' => true,
            ],
            [
                'code' => 'FLASH50K',
                'type' => 'fixed',
                'value' => 50000.00,
                'min_amount' => 500000.00,
                'max_uses' => 25,
                'used_count' => 8,
                'expires_at' => now()->addWeeks(2),
                'is_active' => true,
            ],
            [
                'code' => 'FREESHIP',
                'type' => 'fixed',
                'value' => 15000.00,
                'min_amount' => 150000.00,
                'max_uses' => 200,
                'used_count' => 45,
                'expires_at' => now()->addMonths(6),
                'is_active' => true,
            ],
            [
                'code' => 'VIP20',
                'type' => 'percentage',
                'value' => 20.00,
                'min_amount' => 300000.00,
                'max_uses' => 30,
                'used_count' => 18,
                'expires_at' => now()->addMonths(2),
                'is_active' => true,
            ],
            [
                'code' => 'EXPIRED2025',
                'type' => 'percentage',
                'value' => 50.00,
                'min_amount' => 200000.00,
                'max_uses' => 10,
                'used_count' => 10,
                'expires_at' => now()->subDays(30),
                'is_active' => false,
            ],
        ];

        foreach ($coupons as $coupon) {
            Coupon::create($coupon);
        }
    }
}
