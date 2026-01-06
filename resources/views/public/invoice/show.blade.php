@extends('layouts.public')

@section('title', 'Invoice - ' . $transaction->invoice_code)

@section('content')
    <div class="container mx-auto px-4 py-12">
        <div class="max-w-3xl mx-auto">
            <!-- Success Message -->
            <div class="bg-green-500/10 border border-green-500/20 rounded-xl p-6 mb-8 text-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-16 h-16 mx-auto text-green-400 mb-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h1 class="text-2xl font-bold text-green-400 mb-2">Order Placed Successfully!</h1>
                <p class="text-green-300">Your invoice code: <strong>{{ $transaction->invoice_code }}</strong></p>
            </div>

            <!-- Invoice Details -->
            <div class="bg-surface border border-border rounded-xl p-6 mb-6">
                <h2 class="text-xl font-bold text-primary mb-6">Invoice Details</h2>
                
                <!-- Customer Info -->
                <div class="mb-6">
                    <h3 class="text-sm font-bold text-secondary mb-3">Customer Information</h3>
                    <div class="space-y-1 text-sm">
                        <p><span class="text-secondary">Name:</span> <span class="text-primary font-medium">{{ $transaction->customer_info['name'] }}</span></p>
                        <p><span class="text-secondary">WhatsApp:</span> <span class="text-primary font-medium">{{ $transaction->customer_info['whatsapp'] }}</span></p>
                        <p><span class="text-secondary">Address:</span> <span class="text-primary">{{ $transaction->customer_info['address'] }}</span></p>
                    </div>
                </div>

                <!-- Order Items -->
                <div class="mb-6">
                    <h3 class="text-sm font-bold text-secondary mb-3">Order Items</h3>
                    <div class="space-y-2">
                        @foreach($transaction->items as $item)
                            <div class="flex justify-between text-sm">
                                <div>
                                    <p class="text-primary font-medium">{{ $item->product_snapshot['name'] }}</p>
                                    <p class="text-xs text-secondary">{{ $item->quantity }} x Rp {{ number_format($item->price_locked, 0, ',', '.') }}</p>
                                </div>
                                <p class="text-primary font-mono">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Payment Summary -->
                <div class="border-t border-border pt-4">
                    <div class="space-y-2">
                        <div class="flex justify-between text-sm text-secondary">
                            <span>Subtotal</span>
                            <span class="font-mono">Rp {{ number_format($transaction->amount_subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-sm text-secondary">
                            <span>Unique Code</span>
                            <span class="font-mono text-green-400">+ {{ $transaction->unique_code }}</span>
                        </div>
                        <div class="border-t border-border pt-2">
                            <div class="flex justify-between text-xl font-bold text-primary">
                                <span>Total Payment</span>
                                <span class="font-mono">Rp {{ number_format($transaction->amount_total, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Instructions -->
            @if($transaction->payment_method === 'bank_transfer')
                <div class="bg-blue-500/10 border border-blue-500/20 rounded-xl p-6 mb-6">
                    <h2 class="text-lg font-bold text-blue-400 mb-4">Bank Transfer Payment Instructions</h2>
                    <ol class="space-y-3 text-sm text-blue-300">
                        <li>1. Transfer <strong class="font-mono">Rp {{ number_format($transaction->amount_total, 0, ',', '.') }}</strong> to:</li>
                        <li class="pl-4">
                            <div class="bg-blue-500/20 rounded p-3">
                                <p class="font-bold">Bank BCA</p>
                                <p>Account: 1234567890</p>
                                <p>Name: LaravelCataShop</p>
                            </div>
                        </li>
                        <li>2. Save your payment receipt</li>
                        <li>3. Contact us via WhatsApp with your invoice code: <strong>{{ $transaction->invoice_code }}</strong></li>
                        <li>4. We will verify and process your order immediately</li>
                    </ol>
                </div>
            @else
                <div class="bg-yellow-500/10 border border-yellow-500/20 rounded-xl p-6 mb-6">
                    <h2 class="text-lg font-bold text-yellow-400 mb-4">Cash on Delivery (COD)</h2>
                    <p class="text-sm text-yellow-300 mb-3">Please prepare cash: <strong class="font-mono">Rp {{ number_format($transaction->amount_total, 0, ',', '.') }}</strong></p>
                    <p class="text-sm text-yellow-300">We will contact you via WhatsApp to confirm delivery schedule.</p>
                </div>
            @endif

            <!-- Actions -->
            <div class="flex gap-4">
                <a href="{{ route('home') }}" class="flex-1 bg-primary text-background text-center px-6 py-3 rounded-lg font-bold hover:opacity-90 transition-opacity">
                    Back to Home
                </a>
                <a href="{{ route('catalog.index') }}" class="flex-1 border border-border text-center px-6 py-3 rounded-lg font-bold hover:border-primary/50 transition-colors">
                    Continue Shopping
                </a>
            </div>
        </div>
    </div>
@endsection
