<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\CustomerAddress;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create demo customer
        $customer = Customer::create([
            'name' => 'Demo Customer',
            'email' => 'customer@example.com',
            'whatsapp' => '081234567890',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        // Create default address
        CustomerAddress::create([
            'customer_id' => $customer->id,
            'label' => 'Home',
            'address' => 'Jl. Contoh No. 123, Jakarta Selatan, DKI Jakarta 12345',
            'is_default' => true,
        ]);

        // Create office address
        CustomerAddress::create([
            'customer_id' => $customer->id,
            'label' => 'Office',
            'address' => 'Jl. Kantor No. 456, Jakarta Pusat, DKI Jakarta 10110',
            'is_default' => false,
        ]);
    }
}
