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
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6 mb-8">
            @forelse($products as $product)
                <a href="{{ route('products.show', $product) }}" class="bg-surface border border-border rounded-xl overflow-hidden hover:border-primary/50 transition-all duration-300 group">
                    @if($product->images && count($product->images) > 0)
                        <img src="{{ asset('storage/' . $product->images[0]) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover">
                    @else
                        <div class="w-full h-48 bg-secondary/10 flex items-center justify-center text-secondary text-sm">No Image</div>
                    @endif
                    <div class="p-4">
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
                    </div>
                </a>
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
