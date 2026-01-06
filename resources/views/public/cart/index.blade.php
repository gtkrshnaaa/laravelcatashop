@extends('layouts.public')

@section('title', 'Shopping Cart')

@section('content')
    <div class="container mx-auto px-4 py-12">
        <h1 class="text-4xl font-bold text-primary mb-8">Shopping Cart</h1>

        @if(count($cartItems) > 0)
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Cart Items -->
                <div class="lg:col-span-2 space-y-4">
                    @foreach($cartItems as $item)
                        <div class="bg-surface border border-border rounded-xl p-6 flex gap-6">
                            <!-- Product Image -->
                            <div class="flex-shrink-0">
                                @if($item['product']->images && count($item['product']->images) > 0)
                                    <img src="{{ asset('storage/' . $item['product']->images[0]) }}" alt="{{ $item['product']->name }}" class="w-24 h-24 object-cover rounded-lg">
                                @else
                                    <div class="w-24 h-24 bg-secondary/10 rounded-lg flex items-center justify-center text-secondary text-xs">No Image</div>
                                @endif
                            </div>

                            <!-- Product Info -->
                            <div class="flex-1">
                                <a href="{{ route('products.show', $item['product']) }}" class="font-bold text-primary hover:underline mb-1 block">
                                    {{ $item['product']->name }}
                                </a>
                                <p class="text-xs text-secondary mb-3">{{ $item['product']->category->name }}</p>
                                <p class="text-lg font-bold text-primary font-mono">Rp {{ number_format($item['product']->price, 0, ',', '.') }}</p>

                                <!-- Quantity Control -->
                                <form action="{{ route('cart.update', $item['product']->id) }}" method="POST" class="mt-4 flex items-center gap-2">
                                    @csrf
                                    @method('PATCH')
                                    <label for="quantity-{{ $item['product']->id }}" class="text-sm text-secondary">Qty:</label>
                                    <input type="number" id="quantity-{{ $item['product']->id }}" name="quantity" value="{{ $item['quantity'] }}" min="1" 
                                        @if($item['product']->stock_control) max="{{ $item['product']->stock }}" @endif
                                        class="w-20 bg-background border border-border rounded px-3 py-1 text-primary text-center">
                                    <button type="submit" class="text-sm text-primary hover:underline">Update</button>
                                </form>
                            </div>

                            <!-- Subtotal & Remove -->
                            <div class="flex flex-col items-end justify-between">
                                <p class="text-xl font-bold text-primary font-mono">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</p>
                                <form action="{{ route('cart.remove', $item['product']->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-sm text-red-500 hover:text-red-400" onclick="return confirm('Remove this item from cart?')">Remove</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Cart Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-surface border border-border rounded-xl p-6 sticky top-20">
                        <h2 class="text-xl font-bold text-primary mb-6">Order Summary</h2>
                        
                        <div class="space-y-3 mb-6">
                            <div class="flex justify-between text-secondary">
                                <span>Subtotal</span>
                                <span class="font-mono">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                            </div>
                            <div class="border-t border-border pt-3">
                                <div class="flex justify-between text-lg font-bold text-primary">
                                    <span>Total</span>
                                    <span class="font-mono">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>

                        <a href="{{ route('checkout.index') }}" class="block w-full bg-primary text-background text-center px-6 py-3 rounded-lg font-bold hover:opacity-90 transition-opacity mb-3">
                            Proceed to Checkout
                        </a>

                        <a href="{{ route('catalog.index') }}" class="block w-full text-center text-secondary hover:text-primary transition-colors text-sm">
                            Continue Shopping
                        </a>

                        <form action="{{ route('cart.clear') }}" method="POST" class="mt-4">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full text-center text-red-500 hover:text-red-400 text-sm" onclick="return confirm('Clear entire cart?')">
                                Clear Cart
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @else
            <div class="bg-surface border border-border rounded-xl p-12 text-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-16 h-16 mx-auto text-secondary mb-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                </svg>
                <h2 class="text-2xl font-bold text-primary mb-2">Your cart is empty</h2>
                <p class="text-secondary mb-6">Add some products to get started!</p>
                <a href="{{ route('catalog.index') }}" class="inline-block bg-primary text-background px-8 py-3 rounded-lg font-bold hover:opacity-90 transition-opacity">
                    Browse Catalog
                </a>
            </div>
        @endif
    </div>
@endsection
