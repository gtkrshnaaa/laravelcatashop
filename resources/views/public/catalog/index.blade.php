@extends('layouts.public')

@section('title', 'Catalog')

@section('content')
    <div class="container mx-auto px-4 py-12">
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-primary mb-2">Product Catalog</h1>
            <p class="text-secondary">Browse our complete collection</p>
        </div>

        <!-- Filters -->
        <div class="bg-surface border border-border rounded-xl p-6 mb-8">
            <form action="{{ route('catalog.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
                <div class="flex-1">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search products..." 
                        class="w-full bg-background border border-border rounded-lg px-4 py-3 text-primary focus:ring-1 focus:ring-primary focus:border-primary transition-colors outline-none">
                </div>
                <div class="w-full md:w-64">
                    <select name="category" 
                        class="w-full bg-background border border-border rounded-lg px-4 py-3 text-primary focus:ring-1 focus:ring-primary focus:border-primary transition-colors outline-none">
                        <option value="">All Categories</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }} ({{ $cat->products_count }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="bg-primary text-background px-6 py-3 rounded-lg font-bold hover:opacity-90 transition-opacity">
                    Filter
                </button>
            </form>
        </div>

        <!-- Products Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6 mb-8" x-data="{ wishlisted: {{ json_encode(auth('customer')->user() ? auth('customer')->user()->wishlists()->pluck('product_id') : []) }} }">
            <script>
                // Listen for global wishlist updates
                window.addEventListener('wishlist-updated', event => {
                    const productId = event.detail.productId;
                    const status = event.detail.status;
                    
                    const list = Alpine.store('wishlistedData') || [];
                    if (status === 'added') {
                         if(!list.includes(productId)) list.push(productId);
                    } else {
                         const index = list.indexOf(productId);
                         if(index > -1) list.splice(index, 1);
                    }
                });
            </script>

            @forelse($products as $product)
                <div class="group relative bg-surface border border-border rounded-xl overflow-hidden hover:border-primary/50 transition-all duration-300">
                    <a href="{{ route('products.show', $product) }}" class="block">
                        @if($product->images && count($product->images) > 0)
                            <img src="{{ asset('storage/' . $product->images[0]) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                            <div class="w-full h-48 bg-secondary/10 flex items-center justify-center text-secondary text-sm">No Image</div>
                        @endif
                    </a>

                    <!-- Wishlist Button -->
                    <div class="absolute top-3 right-3 z-10" x-data="wishlist">
                        <button 
                            @click="toggle({{ $product->id }})"
                            class="bg-surface/80 backdrop-blur-md p-2 rounded-full border border-border hover:bg-surface transition-colors shadow-sm group/btn"
                            :class="{ 'text-red-500 border-red-500/30': wishlisted.includes({{ $product->id }}) }"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" 
                                :fill="wishlisted.includes({{ $product->id }}) ? 'currentColor' : 'none'" 
                                viewBox="0 0 24 24" 
                                stroke-width="1.5" 
                                stroke="currentColor" 
                                class="w-5 h-5 transition-transform group-hover/btn:scale-110"
                                :class="{ 'text-red-500': wishlisted.includes({{ $product->id }}) }"
                            >
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.008 11.525c.03.693-.069 1.341-.274 1.948-1.558 4.673-8.736 9.387-8.736 9.387S4.852 18.146 3.294 13.473c-.205-.607-.304-1.255-.274-1.948 0-2.834 2.128-5.132 4.965-5.32 2.373-.157 4.542 1.543 4.965 3.664.423-2.121 2.592-3.821 4.965-3.664 2.837.188 4.965 2.486 4.965 5.32z" />
                            </svg>
                        </button>
                    </div>

                    <a href="{{ route('products.show', $product) }}" class="block p-4">
                        <h3 class="font-bold text-primary mb-1 truncate group-hover:text-primary transition-colors">{{ $product->name }}</h3>
                        <p class="text-xs text-secondary mb-3">{{ $product->category->name }}</p>
                        <div class="flex items-center justify-between">
                            <p class="text-lg font-bold text-primary font-mono">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                            @if($product->stock_control)
                                <span class="text-xs text-secondary">Stock: {{ $product->stock }}</span>
                            @else
                                <span class="text-xs text-green-400">Available</span>
                            @endif
                        </div>
                    </a>
                </div>
            @empty
                <div class="col-span-full text-center py-12 text-secondary">
                    No products found. Try adjusting your filters.
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $products->links() }}
        </div>
    </div>
@endsection
