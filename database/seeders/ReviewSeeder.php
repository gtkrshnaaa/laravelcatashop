<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductReview;
use App\Models\Customer;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customer = Customer::first();
        $products = Product::take(10)->get();

        $reviews = [
            [
                'rating' => 5,
                'review' => 'Produk sangat berkualitas! Pengiriman cepat dan packaging rapi. Sangat puas dengan pembelian ini. Highly recommended!',
                'status' => 'approved',
            ],
            [
                'rating' => 4,
                'review' => 'Overall bagus, sesuai deskripsi. Hanya saja warnanya sedikit berbeda dari foto. Tapi tetap worth it!',
                'status' => 'approved',
            ],
            [
                'rating' => 5,
                'review' => 'Best purchase ever! Kualitas premium dengan harga terjangkau. Seller responsif dan helpful. Will order again!',
                'status' => 'approved',
            ],
            [
                'rating' => 3,
                'review' => 'Produk oke, tapi pengiriman agak lama. Semoga next time bisa lebih cepat.',
                'status' => 'approved',
            ],
            [
                'rating' => 5,
                'review' => 'Amazing quality! Exactly as described. Fast shipping and excellent customer service. 10/10 would recommend!',
                'status' => 'approved',
            ],
            [
                'rating' => 4,
                'review' => 'Good product, good price. Sempat ada kendala tapi admin fast response. Thanks!',
                'status' => 'approved',
            ],
            [
                'rating' => 2,
                'review' => 'Kurang sesuai ekspektasi. Kualitas biasa saja.',
                'status' => 'pending',
            ],
            [
                'rating' => 5,
                'review' => 'Superb! Material berkualitas tinggi, finishing rapi. Sangat merekomendasikan untuk yang cari kualitas terbaik.',
                'status' => 'approved',
            ],
            [
                'rating' => 4,
                'review' => 'Produk bagus, harga reasonable. Pengalaman belanja yang menyenangkan!',
                'status' => 'approved',
            ],
            [
                'rating' => 5,
                'review' => 'Perfect! No complaints at all. Fast delivery, great quality, excellent service!',
                'status' => 'approved',
            ],
        ];

        // Add guest reviews
        $guestReviews = [
            [
                'guest_name' => 'Anonymous Buyer',
                'rating' => 5,
                'review' => 'Great product! Very satisfied with my purchase.',
                'status' => 'approved',
            ],
            [
                'guest_name' => 'Happy Customer',
                'rating' => 4,
                'review' => 'Good quality for the price. Recommended!',
                'status' => 'approved',
            ],
        ];

        foreach ($products as $index => $product) {
            // Customer review
            if (isset($reviews[$index])) {
                ProductReview::create([
                    'product_id' => $product->id,
                    'customer_id' => $customer->id,
                    'rating' => $reviews[$index]['rating'],
                    'review' => $reviews[$index]['review'],
                    'status' => $reviews[$index]['status'],
                    'helpful_count' => rand(0, 15),
                ]);
            }

            // Guest review
            if (isset($guestReviews[$index % 2])) {
                ProductReview::create([
                    'product_id' => $product->id,
                    'guest_name' => $guestReviews[$index % 2]['guest_name'],
                    'rating' => $guestReviews[$index % 2]['rating'],
                    'review' => $guestReviews[$index % 2]['review'],
                    'status' => $guestReviews[$index % 2]['status'],
                    'helpful_count' => rand(0, 8),
                ]);
            }
        }
    }
}
