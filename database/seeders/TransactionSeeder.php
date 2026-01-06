<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customer = Customer::first();
        $products = Product::take(15)->get();

        // Sample transactions with different statuses
        $transactions = [
            [
                'customer_id' => $customer->id,
                'customer_info' => [
                    'name' => $customer->name,
                    'whatsapp' => $customer->whatsapp,
                    'address' => 'Jl. Contoh No. 123, Jakarta Selatan, DKI Jakarta 12345',
                ],
                'payment_method' => 'bank_transfer',
                'status' => 'completed',
                'products' => [$products[0], $products[1]],
                'quantities' => [2, 1],
                'created_days_ago' => 15,
            ],
            [
                'customer_id' => $customer->id,
                'customer_info' => [
                    'name' => $customer->name,
                    'whatsapp' => $customer->whatsapp,
                    'address' => 'Jl. Kantor No. 456, Jakarta Pusat, DKI Jakarta 10110',
                ],
                'payment_method' => 'cod',
                'status' => 'shipped',
                'products' => [$products[2], $products[3], $products[4]],
                'quantities' => [1, 1, 2],
                'created_days_ago' => 5,
            ],
            [
                'customer_id' => $customer->id,
                'customer_info' => [
                    'name' => $customer->name,
                    'whatsapp' => $customer->whatsapp,
                    'address' => 'Jl. Contoh No. 123, Jakarta Selatan, DKI Jakarta 12345',
                ],
                'payment_method' => 'bank_transfer',
                'status' => 'paid',
                'products' => [$products[5]],
                'quantities' => [3],
                'created_days_ago' => 3,
            ],
            [
                'customer_id' => $customer->id,
                'customer_info' => [
                    'name' => $customer->name,
                    'whatsapp' => $customer->whatsapp,
                    'address' => 'Jl. Contoh No. 123, Jakarta Selatan, DKI Jakarta 12345',
                ],
                'payment_method' => 'bank_transfer',
                'status' => 'unpaid',
                'products' => [$products[6], $products[7]],
                'quantities' => [1, 1],
                'created_days_ago' => 1,
            ],
            [
                'customer_id' => null,
                'customer_info' => [
                    'name' => 'Guest Customer',
                    'whatsapp' => '081234567890',
                    'address' => 'Jl. Guest No. 789, Bandung, Jawa Barat 40123',
                ],
                'payment_method' => 'bank_transfer',
                'status' => 'completed',
                'products' => [$products[8], $products[9]],
                'quantities' => [2, 1],
                'created_days_ago' => 10,
            ],
            [
                'customer_id' => null,
                'customer_info' => [
                    'name' => 'Another Guest',
                    'whatsapp' => '081987654321',
                    'address' => 'Jl. Another No. 321, Surabaya, Jawa Timur 60123',
                ],
                'payment_method' => 'cod',
                'status' => 'unpaid',
                'products' => [$products[10]],
                'quantities' => [1],
                'created_days_ago' => 2,
            ],
        ];

        foreach ($transactions as $data) {
            $subtotal = 0;
            $itemsData = [];

            foreach ($data['products'] as $index => $product) {
                $quantity = $data['quantities'][$index];
                $itemSubtotal = $product->price * $quantity;
                $subtotal += $itemSubtotal;

                $itemsData[] = [
                    'product' => $product,
                    'quantity' => $quantity,
                    'price' => $product->price,
                    'subtotal' => $itemSubtotal,
                ];
            }

            // Generate unique code
            $uniqueCode = rand(100, 999);
            $total = $subtotal + $uniqueCode;

            // Generate invoice code
            $invoiceCode = 'INV-' . now()->subDays($data['created_days_ago'])->format('Ymd') . '-' . strtoupper(substr(md5(uniqid()), 0, 6));

            // Create transaction
            $transaction = Transaction::create([
                'invoice_code' => $invoiceCode,
                'customer_id' => $data['customer_id'],
                'customer_info' => $data['customer_info'],
                'payment_method' => $data['payment_method'],
                'unique_code' => $uniqueCode,
                'amount_subtotal' => $subtotal,
                'amount_total' => $total,
                'status' => $data['status'],
                'created_at' => now()->subDays($data['created_days_ago']),
                'updated_at' => now()->subDays($data['created_days_ago']),
            ]);

            // Create transaction items
            foreach ($itemsData as $item) {
                TransactionItem::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $item['product']->id,
                    'product_snapshot' => [
                        'name' => $item['product']->name,
                        'sku' => $item['product']->sku,
                    ],
                    'quantity' => $item['quantity'],
                    'price_locked' => $item['price'],
                    'subtotal' => $item['subtotal'],
                ]);
            }
        }
    }
}
