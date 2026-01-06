@extends('layouts.public')

@section('title', 'Home')

@section('content')
    <!-- Hero Section -->
    <section class="container mx-auto px-4 py-16 md:py-24">
        <div class="max-w-4xl mx-auto text-center">
            <h1 class="text-5xl md:text-7xl font-bold mb-6 tracking-tight">
                <span class="bg-gradient-to-r from-primary to-secondary bg-clip-text text-transparent">Welcome to CataShop</span>
            </h1>
            <p class="text-xl text-secondary mb-8">Simple e-commerce solution built with Laravel. Browse our catalog and discover amazing products.</p>
            <a href="{{ route('catalog.index') }}" class="bg-primary text-background px-8 py-4 rounded-lg font-bold hover:opacity-90 transition-opacity inline-block">
                Browse Catalog
            </a>
        </div>
    </section>

    <!-- Featured Categories -->
    @if($featuredCategories->count() > 0)
    <section class="container mx-auto px-4 py-12">
        <h2 class="text-3xl font-bold mb-8 text-primary">Featured Categories</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            @foreach($featuredCategories as $category)
                <a href="{{ route('catalog.index', ['category' => $category->id]) }}" class="bg-surface border border-border rounded-xl p-6 hover:border-primary/50 transition-all duration-300 group">
                    <h3 class="font-bold text-primary mb-2 group-hover:text-primary transition-colors">{{ $category->name }}</h3>
                    <p class="text-xs text-secondary">{{ $category->products_count }} products</p>
                </a>
            @endforeach
        </div>
    </section>
    @endif

    <!-- Featured Products -->
    @if($featuredProducts->count() > 0)
    <section class="container mx-auto px-4 py-12">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-3xl font-bold text-primary">Latest Products</h2>
            <a href="{{ route('catalog.index') }}" class="text-sm text-secondary hover:text-primary transition-colors">View All →</a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($featuredProducts as $product)
                <a href="{{ route('products.show', $product) }}" class="bg-surface border border-border rounded-xl overflow-hidden hover:border-primary/50 transition-all duration-300 group">
                    @if($product->images && count($product->images) > 0)
                        <img src="{{ asset('storage/' . $product->images[0]) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover">
                    @else
                        <div class="w-full h-48 bg-secondary/10 flex items-center justify-center text-secondary text-sm">No Image</div>
                    @endif
                    <div class="p-4">
                        <h3 class="font-bold text-primary mb-1 group-hover:text-primary transition-colors">{{ $product->name }}</h3>
                        <p class="text-xs text-secondary mb-3">{{ $product->category->name }}</p>
                        <p class="text-lg font-bold text-primary font-mono">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    </section>
    @endif
@endsection
