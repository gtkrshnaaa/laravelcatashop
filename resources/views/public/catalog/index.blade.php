@extends('layouts.public')

@section('title', 'Catalog')

@section('content')
    <div class="container mx-auto px-4 py-12">
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-primary mb-2">Product Catalog</h1>
            <p class="text-secondary">Browse our complete collection</p>
        </div>

        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Filter Sidebar -->
            <aside class="w-full lg:w-72 flex-shrink-0 space-y-8">
                <form action="{{ route('catalog.index') }}" method="GET" id="filterForm">
                    <!-- Maintain search if exists -->
                    @if(request('search'))
                        <input type="hidden" name="search" value="{{ request('search') }}">
                    @endif

                    <!-- Search Mobile/Sidebar Duplicate for convenience or just rely on top? Let's add a clear Search here too -->
                    <div class="bg-surface border border-border rounded-xl p-6 mb-6">
                        <h3 class="font-bold text-primary mb-4">Search</h3>
                        <div class="relative">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search..." 
                                class="w-full bg-background border border-border rounded-lg pl-4 pr-10 py-2 text-primary focus:ring-1 focus:ring-primary focus:border-primary transition-colors outline-none text-sm">
                            <button type="submit" class="absolute right-3 top-2.5 text-secondary hover:text-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                                    <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Categories -->
                    <div class="bg-surface border border-border rounded-xl p-6 mb-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="font-bold text-primary">Categories</h3>
                        </div>
                        <div class="space-y-3">
                            <!-- All Categories Option -->
                            <label class="flex items-center gap-3 cursor-pointer group">
                                <input type="radio" name="category" value="" class="peer sr-only" {{ !request('category') ? 'checked' : '' }} onchange="this.form.submit()">
                                
                                <!-- Custom Radio UI -->
                                <div class="w-5 h-5 rounded-full border-2 border-zinc-700 bg-zinc-900 peer-checked:border-white peer-checked:bg-white flex items-center justify-center transition-all group-hover:border-zinc-500 shadow-sm">
                                    <div class="w-2 h-2 rounded-full bg-black transform scale-0 peer-checked:scale-100 transition-transform duration-200"></div>
                                </div>

                                <span class="text-zinc-400 font-medium group-hover:text-white peer-checked:text-white peer-checked:font-bold transition-colors text-sm">All Categories</span>
                            </label>

                            <!-- Dynamic Categories -->
                            @foreach($categories as $cat)
                                <label class="flex items-center justify-between cursor-pointer group">
                                    <div class="flex items-center gap-3">
                                        <input type="radio" name="category" value="{{ $cat->id }}" class="peer sr-only" {{ request('category') == $cat->id ? 'checked' : '' }} onchange="this.form.submit()">
                                        
                                        <!-- Custom Radio UI -->
                                        <div class="w-5 h-5 rounded-full border-2 border-zinc-700 bg-zinc-900 peer-checked:border-white peer-checked:bg-white flex items-center justify-center transition-all group-hover:border-zinc-500 shadow-sm">
                                            <div class="w-2 h-2 rounded-full bg-black transform scale-0 peer-checked:scale-100 transition-transform duration-200"></div>
                                        </div>

                                        <span class="text-zinc-400 group-hover:text-white peer-checked:text-white peer-checked:font-medium transition-colors text-sm">{{ $cat->name }}</span>
                                    </div>
                                    
                                    <!-- Count Badge -->
                                    <span class="text-[10px] font-bold text-zinc-500 bg-zinc-900 px-2 py-0.5 rounded-full border border-zinc-800 group-hover:border-zinc-700 transition-colors">
                                        {{ $cat->products_count }}
                                    </span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Price Range -->
                    <div class="bg-surface border border-border rounded-xl p-6 mb-6">
                        <h3 class="font-bold text-primary mb-4">Price Range</h3>
                        <div class="flex items-center gap-2 mb-4">
                            <div class="relative flex-1">
                                <span class="absolute left-3 top-2 text-xs text-secondary">Rp</span>
                                <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="Min" 
                                    class="w-full bg-background border border-border rounded-lg pl-8 pr-2 py-2 text-sm text-primary focus:ring-1 focus:ring-primary focus:border-primary outline-none">
                            </div>
                            <span class="text-secondary">-</span>
                            <div class="relative flex-1">
                                <span class="absolute left-3 top-2 text-xs text-secondary">Rp</span>
                                <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Max" 
                                    class="w-full bg-background border border-border rounded-lg pl-8 pr-2 py-2 text-sm text-primary focus:ring-1 focus:ring-primary focus:border-primary outline-none">
                            </div>
                        </div>
                        <button type="submit" class="w-full bg-secondary/10 hover:bg-secondary/20 text-primary text-sm font-bold py-2 rounded-lg transition-colors">
                            Apply Price
                        </button>
                    </div>

                    <!-- Tags (if available) -->
                    @if(isset($tags) && $tags->count() > 0)
                        <div class="bg-surface border border-border rounded-xl p-6">
                            <h3 class="font-bold text-primary mb-4">Tags</h3>
                            <div class="flex flex-wrap gap-2">
                                @foreach($tags as $tag)
                                    <label class="cursor-pointer">
                                        <input type="checkbox" name="tags[]" value="{{ $tag->slug }}" 
                                            class="hidden peer" 
                                            {{ in_array($tag->slug, is_array(request('tags')) ? request('tags') : explode(',', request('tags') ?? '')) ? 'checked' : '' }}>
                                        <span class="inline-block px-3 py-1 text-xs rounded-full border border-border bg-background text-secondary peer-checked:bg-primary peer-checked:text-background peer-checked:border-primary hover:border-primary/50 transition-all select-none">
                                            {{ $tag->name }}
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                            <button type="submit" class="mt-4 w-full bg-secondary/10 hover:bg-secondary/20 text-primary text-sm font-bold py-2 rounded-lg transition-colors">
                                Apply Filters
                            </button>
                        </div>
                    @endif
                </form>
            </aside>

            <!-- Main Content -->
            <div class="flex-1">
                <!-- Sorting & Info -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 bg-surface border border-border rounded-xl p-4">
                    <p class="text-secondary text-sm">Showing <span class="font-bold text-primary">{{ $products->firstItem() ?? 0 }}-{{ $products->lastItem() ?? 0 }}</span> of <span class="font-bold text-primary">{{ $products->total() }}</span> results</p>
                    
                    <div class="flex items-center gap-2">
                        <span class="text-sm text-secondary">Sort by:</span>
                        <select name="sort" form="filterForm" onchange="this.form.submit()" class="bg-background border border-border rounded-lg px-3 py-1.5 text-sm text-primary focus:ring-1 focus:ring-primary focus:border-primary outline-none cursor-pointer">
                            <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Newest Arrivals</option>
                            <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                            <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                            <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Most Popular</option>
                        </select>
                    </div>
                </div>

                <!-- Active Filters Badges -->
                @if(request('min_price') || request('max_price') || request('search') || request('tags'))
                    <div class="flex flex-wrap gap-2 mb-6">
                        @if(request('search'))
                             <span class="inline-flex items-center gap-1 px-3 py-1 bg-primary/10 text-primary text-xs rounded-full">
                                Search: "{{ request('search') }}"
                                <a href="{{ route('catalog.index', request()->except('search')) }}" class="hover:text-red-500">×</a>
                             </span>
                        @endif
                         @if(request('min_price'))
                             <span class="inline-flex items-center gap-1 px-3 py-1 bg-primary/10 text-primary text-xs rounded-full">
                                Min: Rp {{ number_format(request('min_price'), 0, ',', '.') }}
                                <a href="{{ route('catalog.index', request()->except('min_price')) }}" class="hover:text-red-500">×</a>
                             </span>
                        @endif
                        <!-- Add other badges as needed -->
                        <a href="{{ route('catalog.index') }}" class="px-3 py-1 text-xs text-red-500 hover:underline">Clear All</a>
                    </div>
                @endif

                <!-- Products Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8" x-data="{ wishlisted: {{ json_encode(auth('customer')->user() ? auth('customer')->user()->wishlists()->pluck('product_id') : []) }} }">
                    <script>
                        window.addEventListener('wishlist-updated', event => {
                            const productId = event.detail.productId;
                            const status = event.detail.status;
                            const list = Alpine.store('wishlistedData') || [];
                            // Logic handled by x-data array mutation below if we used a store, but here we use local state
                            // We need to access the x-data scope. Ideally, we define this data in a store or parent.
                            // For now, let's keep it simple and just reload if needed or assume local state matches.
                            // Actually, the safest way for independent components to sync is via the window event modifying a store.
                            // But since we are inside the component loop, let's just use the toggle logic which updates backend.
                            // UI sync is handled by the button's own click for immediate feedback.
                        });
                    </script>
        
                    @forelse($products as $product)
                        <div class="group relative bg-surface border border-border rounded-xl overflow-hidden hover:border-primary/50 transition-all duration-300 flex flex-col h-full">
                            <a href="{{ route('products.show', $product) }}" class="block relative overflow-hidden">
                                @if($product->images && count($product->images) > 0)
                                    <img src="{{ asset('storage/' . $product->images[0]) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-500">
                                @else
                                    <div class="w-full h-48 bg-secondary/10 flex items-center justify-center text-secondary text-sm">No Image</div>
                                @endif
                                
                                @if($product->discount_percentage)
                                    <div class="absolute top-3 left-3 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-md">
                                        -{{ $product->discount_percentage }}%
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
        
                            <div class="p-4 flex flex-col flex-1">
                                <a href="{{ route('products.show', $product) }}" class="block flex-1">
                                    <p class="text-xs text-secondary mb-1">{{ $product->category->name }}</p>
                                    <h3 class="font-bold text-primary mb-2 truncate group-hover:text-primary transition-colors">{{ $product->name }}</h3>
                                    
                                    <div class="flex items-end justify-between mt-auto">
                                        <div>
                                            <p class="text-lg font-bold text-primary font-mono">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                            @if($product->search_count > 50)
                                                 <p class="text-[10px] text-amber-500 flex items-center gap-1 mt-1">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3 h-3"><path fill-rule="evenodd" d="M13.5 4.938a7 7 0 11-9.006 1.737c.202-.257.59-.218.793.08a5.002 5.002 0 007.82.217c.05-.06.098-.12.144-.183.173-.242.508-.286.733-.11.226.177.265.503.087.738a7.002 7.002 0 01-10.957-1.393.57.57 0 01.127-.72c.225-.177.553-.13.725.1a5.002 5.002 0 008.57-1.353.568.568 0 01.698-.387c.277.08.435.372.355.65z" clip-rule="evenodd" /></svg>
                                                    Popular
                                                 </p>
                                            @endif
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full text-center py-12 rounded-xl border border-dashed border-border text-secondary">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12 mx-auto mb-4 opacity-50">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                            </svg>
                            <p class="text-lg font-medium">No products found</p>
                            <p class="text-sm">Try adjusting your filters or search terms</p>
                            <a href="{{ route('catalog.index') }}" class="inline-block mt-4 text-primary hover:underline">Clear all filters</a>
                        </div>
                    @endforelse
                </div>
        
                <!-- Pagination -->
                <div class="mt-8">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
