@extends('layouts.public')

@section('title', 'Welcome to CataShop')

@section('content')
    <!-- Hero Section with Carousel -->
    <section class="relative pt-24 pb-0 md:pt-32 md:pb-0 overflow-hidden mb-0" x-data="{ activeSlide: 0, slides: {{ $banners->toJson() }}, init() { setInterval(() => { this.activeSlide = (this.activeSlide + 1) % this.slides.length }, 5000) } }">
        <!-- Background Overlay -->
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top,_var(--tw-gradient-stops))] from-zinc-800/20 via-background to-background opacity-40"></div>
        
        <div class="container mx-auto px-4 relative z-10 text-center min-h-[500px] flex flex-col justify-center items-center">
            
            <!-- Slides Container -->
            <div class="relative w-full max-w-7xl mx-auto h-[400px] md:h-[500px]">
                <template x-for="(slide, index) in slides" :key="index">
                    <div class="absolute inset-0 flex flex-col justify-center items-center transition-all duration-700 ease-in-out"
                         x-show="activeSlide === index"
                         x-transition:enter="opacity-0 translate-y-8"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="opacity-100 translate-y-0"
                         x-transition:leave-end="opacity-0 -translate-y-8" 
                    >
                        <!-- Banner Image (Background or Inline) -->
                        <div class="absolute inset-0 z-0 rounded-3xl overflow-hidden opacity-50">
                            <img :src="'/storage/' + slide.image" 
                                 class="w-full h-full object-cover"
                                 onerror="this.onerror=null; this.src='https://placehold.co/1200x600/18181b/ffffff?text=Image+Not+Found'; console.error('Image failed to load:', this.src)">
                            <div class="absolute inset-0 bg-gradient-to-t from-background via-transparent to-transparent"></div>
                        </div>

                        <div class="relative z-10 max-w-4xl px-4">
                            <h1 class="text-4xl md:text-7xl lg:text-8xl font-bold tracking-tighter text-primary mb-6 leading-tight" x-html="slide.title"></h1>
                            <p class="text-lg md:text-2xl text-secondary mb-8" x-text="slide.subtitle"></p>
                            
                            <a :href="slide.link || '#'" class="inline-block bg-primary text-background px-8 py-4 rounded-full font-bold text-lg hover:opacity-90 transition-transform transform hover:scale-105 shadow-lg shadow-primary/20">
                                <span x-text="slide.button_text || 'Shop Now'"></span>
                            </a>
                        </div>
                    </div>
                </template>
            </div>

            <!-- Carousel Indicators -->
            <div class="absolute bottom-12 left-1/2 transform -translate-x-1/2 flex gap-3 z-20">
                <template x-for="(slide, index) in slides" :key="index">
                    <button @click="activeSlide = index" 
                            class="w-3 h-3 rounded-full transition-all duration-300"
                            :class="activeSlide === index ? 'bg-primary w-8' : 'bg-secondary/30 hover:bg-primary/50'">
                    </button>
                </template>
            </div>
        </div>
    </section>

    <!-- Flash Sale / Scarcity Section -->
    <section class="py-12 bg-background">
        <div class="container mx-auto px-4">
            <div class="bg-surface border border-border rounded-2xl p-6 md:p-8 flex flex-col md:flex-row items-center justify-between gap-8 relative overflow-hidden shadow-2xl shadow-primary/5">
                <!-- Glowing effect -->
                <div class="absolute top-0 right-0 w-64 h-64 bg-primary/5 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>

                <div class="flex-1">
                    <div class="flex items-center gap-3 mb-3">
                        <span class="relative flex h-3 w-3">
                          <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                          <span class="relative inline-flex rounded-full h-3 w-3 bg-red-500"></span>
                        </span>
                        <h3 class="text-sm font-bold text-red-500 tracking-wider uppercase">Flash Sale Ends Soon</h3>
                    </div>
                    <h2 class="text-3xl font-bold text-primary mb-2">Weekly Special Offer</h2>
                    <p class="text-secondary">Don't miss out on our limited time deals. Prices reset every Monday!</p>
                </div>

                <div class="w-full md:w-1/3">
                    <div class="flex items-end justify-between mb-2">
                        <span class="text-xs font-mono text-primary font-bold">{{ $usedSlots }} SOLD</span>
                        <span class="text-xs font-mono {{ $slotsRemaining > 10 ? 'text-green-500' : 'text-red-500' }}">
                            {{ $slotsRemaining }} REMAINING
                        </span>
                    </div>
                    <div class="w-full bg-background border border-border rounded-full h-4 overflow-hidden relative">
                         <div class="absolute top-0 left-0 h-full bg-gradient-to-r from-orange-400 to-red-600 transition-all duration-1000 ease-out" style="width: {{ ($usedSlots / $weeklyLimit) * 100 }}%"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Service Features -->
    <section class="py-12">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($serviceFeatures as $feature)
                    <div class="bg-surface p-8 rounded-2xl border border-border hover:border-primary/50 transition-colors group">
                        <div class="w-12 h-12 rounded-xl bg-{{ $feature['color'] }}-500/10 flex items-center justify-center text-{{ $feature['color'] }}-500 mb-6 group-hover:scale-110 transition-transform">
                            <!-- Simple Icon Placeholder based on name -->
                            @if($feature['icon'] == 'truck')
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12" /></svg>
                            @elseif($feature['icon'] == 'shield-check')
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z" /></svg>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z" /></svg>
                            @endif
                        </div>
                        <h3 class="text-xl font-bold text-primary mb-2">{{ $feature['title'] }}</h3>
                        <p class="text-secondary text-sm">{{ $feature['description'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Featured Categories -->
    <section class="py-12 bg-background">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold mb-8 text-primary">Shop by Category</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                @foreach($featuredCategories as $category)
                    <a href="{{ route('catalog.index', ['category' => $category->id]) }}" class="group relative bg-surface border border-border rounded-2xl p-6 hover:border-primary overflow-hidden transition-all duration-300">
                        <div class="absolute inset-0 bg-gradient-to-br from-primary/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        <div class="relative z-10 text-center">
                            <h3 class="font-bold text-primary mb-2 text-lg group-hover:scale-110 transition-transform">{{ $category->name }}</h3>
                            <p class="text-xs text-secondary">{{ $category->products_count }} Products</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- New Arrivals / Featured Products -->
    <section class="py-20" x-data="{ wishlisted: {{ json_encode(auth('customer')->user() ? auth('customer')->user()->wishlists()->pluck('product_id') : []) }} }">
        <script>
            window.addEventListener('wishlist-updated', event => {
                const productId = event.detail.productId;
                const status = event.detail.status;
                const list = Alpine.store('wishlistedData') || [];
                // Simple reactivity handled by Alpine logic in button below
            });
        </script>

        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between mb-12">
                <div>
                    <h2 class="text-3xl font-bold text-primary mb-2">New Arrivals</h2>
                    <p class="text-secondary">Explore the latest additions to our store.</p>
                </div>
                <a href="{{ route('catalog.index') }}" class="text-sm font-bold text-primary hover:underline">View All &rarr;</a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($featuredProducts as $product)
                <div class="group relative bg-surface border border-border rounded-xl overflow-hidden hover:border-primary/50 hover:shadow-xl hover:shadow-primary/5 transition-all duration-300">
                    <a href="{{ route('products.show', $product) }}" class="block relative overflow-hidden aspect-[4/3]">
                        @if($product->images && count($product->images) > 0)
                            <img src="{{ asset('storage/' . $product->images[0]) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        @else
                            <div class="w-full h-full bg-secondary/10 flex items-center justify-center text-secondary text-sm">No Image</div>
                        @endif

                        @if($product->discount_percentage)
                            <div class="absolute top-3 left-3 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-md shadow-sm">
                                -{{ $product->discount_percentage }}%
                            </div>
                        @endif

                        <!-- View Count Badge -->
                        @if($product->search_count > 0)
                            <div class="absolute bottom-3 left-3 bg-black/50 backdrop-blur text-white text-[10px] px-2 py-1 rounded flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3 h-3"><path d="M10 12.5a2.5 2.5 0 100-5 2.5 2.5 0 000 5z" /><path fill-rule="evenodd" d="M.664 10.59a1.651 1.651 0 010-1.186A10.004 10.004 0 0110 3c4.257 0 7.893 2.66 9.336 6.41.147.381.146.804 0 1.186A10.004 10.004 0 0110 17c-4.257 0-7.893-2.66-9.336-6.41zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" /></svg>
                                {{ number_format($product->search_count) }}
                            </div>
                        @endif
                    </a>

                    <!-- Wishlist Button -->
                    <div class="absolute top-3 right-3 z-10" x-data="wishlist">
                        <button 
                            @click="toggle({{ $product->id }}); if(wishlisted.includes({{ $product->id }})) { wishlisted = wishlisted.filter(id => id !== {{ $product->id }}) } else { wishlisted.push({{ $product->id }}) }"
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

                    <div class="p-4">
                        <p class="text-xs text-secondary mb-1">{{ $product->category->name }}</p>
                        <h3 class="font-bold text-primary mb-2 truncate group-hover:text-primary transition-colors">
                            <a href="{{ route('products.show', $product) }}">{{ $product->name }}</a>
                        </h3>
                        <div class="flex items-center justify-between">
                            <p class="text-lg font-bold text-primary font-mono">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                            @if($product->stock <= 5 && $product->stock > 0)
                                <span class="text-[10px] text-red-500 bg-red-500/10 px-2 py-0.5 rounded-full animate-pulse">Low Stock</span>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Bottom CTA -->
    <section class="py-20 mb-12">
        <div class="container mx-auto px-4">
            <div class="relative overflow-hidden rounded-3xl bg-zinc-900 px-8 py-12 md:px-12 md:py-16 text-center shadow-2xl shadow-zinc-900/20">
                 <!-- Background Gradients -->
                 <div class="absolute top-0 left-0 -translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] bg-gradient-to-br from-blue-500 to-purple-600 blur-3xl opacity-40 rounded-full pointer-events-none"></div>
                 <div class="absolute bottom-0 right-0 translate-x-1/2 translate-y-1/2 w-[500px] h-[500px] bg-gradient-to-tl from-yellow-500 to-orange-500 blur-3xl opacity-40 rounded-full pointer-events-none"></div>

                <div class="relative z-10 max-w-2xl mx-auto">
                    <h2 class="text-3xl font-bold tracking-tight text-white sm:text-4xl mb-4">
                        Ready to start shopping?
                    </h2>
                    <p class="text-lg text-zinc-300 mb-8">
                        Join thousands of satisfied customers and experience the best e-commerce platform built with Laravel.
                    </p>
                    <a href="{{ route('catalog.index') }}" class="inline-block bg-white text-black px-8 py-4 rounded-full font-bold hover:bg-zinc-100 transition-colors transform hover:scale-105 shadow-lg">
                        Browse Full Catalog
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection
