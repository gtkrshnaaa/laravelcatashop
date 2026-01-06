@extends('layouts.public')

@section('title', 'Checkout')

@section('content')
    <div class="container mx-auto px-4 py-12">
        <h1 class="text-4xl font-bold text-primary mb-8">Checkout</h1>

        <form action="{{ route('checkout.store') }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Customer Information -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-surface border border-border rounded-xl p-6">
                        <h2 class="text-xl font-bold text-primary mb-6">Customer Information</h2>
                        
                        <div class="space-y-4">
                            <!-- Name -->
                            <div>
                                <label for="customer_name" class="block text-sm font-medium text-secondary mb-2">Full Name *</label>
                                <input type="text" id="customer_name" name="customer_name" value="{{ old('customer_name') }}" required
                                    class="w-full bg-background border border-border rounded-lg px-4 py-3 text-primary focus:ring-1 focus:ring-primary focus:border-primary transition-colors outline-none">
                                @error('customer_name')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- WhatsApp -->
                            <div>
                                <label for="customer_whatsapp" class="block text-sm font-medium text-secondary mb-2">WhatsApp Number *</label>
                                <input type="text" id="customer_whatsapp" name="customer_whatsapp" value="{{ old('customer_whatsapp') }}" placeholder="08123456789" required
                                    class="w-full bg-background border border-border rounded-lg px-4 py-3 text-primary focus:ring-1 focus:ring-primary focus:border-primary transition-colors outline-none">
                                @error('customer_whatsapp')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Address -->
                            <div>
                                <label for="customer_address" class="block text-sm font-medium text-secondary mb-2">Delivery Address *</label>
                                <textarea id="customer_address" name="customer_address" rows="3" required
                                    class="w-full bg-background border border-border rounded-lg px-4 py-3 text-primary focus:ring-1 focus:ring-primary focus:border-primary transition-colors outline-none">{{ old('customer_address') }}</textarea>
                                @error('customer_address')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Payment Method -->
                            <div>
                                <label class="block text-sm font-medium text-secondary mb-2">Payment Method *</label>
                                <div class="space-y-2">
                                    <label class="flex items-center gap-3 p-4 border border-border rounded-lg cursor-pointer hover:border-primary/50 transition-colors">
                                        <input type="radio" name="payment_method" value="bank_transfer" {{ old('payment_method', 'bank_transfer') == 'bank_transfer' ? 'checked' : '' }} required
                                            class="text-primary focus:ring-primary">
                                        <div>
                                            <p class="font-medium text-primary">Bank Transfer</p>
                                            <p class="text-xs text-secondary">Transfer to our bank account</p>
                                        </div>
                                    </label>
                                    <label class="flex items-center gap-3 p-4 border border-border rounded-lg cursor-pointer hover:border-primary/50 transition-colors">
                                        <input type="radio" name="payment_method" value="cod" {{ old('payment_method') == 'cod' ? 'checked' : '' }} required
                                            class="text-primary focus:ring-primary">
                                        <div>
                                            <p class="font-medium text-primary">Cash on Delivery (COD)</p>
                                            <p class="text-xs text-secondary">Pay when you receive the product</p>
                                        </div>
                                    </label>
                                </div>
                                @error('payment_method')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Notes -->
                            <div>
                                <label for="notes" class="block text-sm font-medium text-secondary mb-2">Order Notes (Optional)</label>
                                <textarea id="notes" name="notes" rows="2"
                                    class="w-full bg-background border border-border rounded-lg px-4 py-3 text-primary focus:ring-1 focus:ring-primary focus:border-primary transition-colors outline-none">{{ old('notes') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-surface border border-border rounded-xl p-6 sticky top-20">
                        <h2 class="text-xl font-bold text-primary mb-6">Order Summary</h2>
                        
                        <!-- Cart Items -->
                        <div class="space-y-3 mb-6 max-h-64 overflow-y-auto">
                            @foreach($cartItems as $item)
                                <div class="flex gap-3 text-sm">
                                    <div class="flex-1">
                                        <p class="font-medium text-primary">{{ $item['product']->name }}</p>
                                        <p class="text-xs text-secondary">Qty: {{ $item['quantity'] }}</p>
                                    </div>
                                    <p class="font-mono text-primary">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</p>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pricing -->
                        <div class="space-y-2 border-t border-border pt-4">
                            <div class="flex justify-between text-sm text-secondary">
                                <span>Subtotal</span>
                                <span class="font-mono">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-sm text-secondary">
                                <span>Unique Code</span>
                                <span class="font-mono text-green-400">+ (will be generated)</span>
                            </div>
                            <div class="border-t border-border pt-2">
                                <div class="flex justify-between text-lg font-bold text-primary">
                                    <span>Total</span>
                                    <span class="font-mono">~Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Place Order Button -->
                        <button type="submit" class="w-full bg-primary text-background px-6 py-3 rounded-lg font-bold hover:opacity-90 transition-opacity mt-6">
                            Place Order
                        </button>

                        <a href="{{ route('cart.index') }}" class="block w-full text-center text-secondary hover:text-primary transition-colors text-sm mt-3">
                            Back to Cart
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
