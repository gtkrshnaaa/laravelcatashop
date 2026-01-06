@extends('layouts.public')

@section('title', $product->name)

@section('content')
    <div class="container mx-auto px-4 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 mb-16">
            <!-- Product Images -->
            <div>
                @if($product->images && count($product->images) > 0)
                    <div class="bg-surface border border-border rounded-xl overflow-hidden mb-4">
                        <img src="{{ asset('storage/' . $product->images[0]) }}" alt="{{ $product->name }}" class="w-full h-96 object-cover">
                    </div>
                    @if(count($product->images) > 1)
                        <div class="grid grid-cols-4 gap-2">
                            @foreach($product->images as $image)
                                <div class="bg-surface border border-border rounded-lg overflow-hidden cursor-pointer hover:border-primary/50 transition-colors">
                                    <img src="{{ asset('storage/' . $image) }}" alt="{{ $product->name }}" class="w-full h-20 object-cover">
                                </div>
                            @endforeach
                        </div>
                    @endif
                @else
                    <div class="bg-secondary/10 rounded-xl flex items-center justify-center h-96 text-secondary">
                        No Image Available
                    </div>
                @endif
            </div>

            <!-- Product Info -->
            <div>
                <div class="mb-6">
                    <a href="{{ route('catalog.index', ['category' => $product->category_id]) }}" class="text-sm text-secondary hover:text-primary transition-colors">
                        {{ $product->category->name }}
                    </a>
                    <h1 class="text-4xl font-bold text-primary mt-2 mb-4">{{ $product->name }}</h1>
                    <p class="text-xs text-secondary font-mono mb-4">SKU: {{ $product->sku }}</p>
                </div>

                <div class="bg-surface border border-border rounded-xl p-6 mb-6">
                    <p class="text-4xl font-bold text-primary font-mono">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                    
                    @if($product->stock_control)
                        <div class="mt-4 flex items-center gap-2">
                            @if($product->stock > 0)
                                <span class="px-3 py-1 bg-green-500/20 text-green-400 text-sm rounded-full">In Stock ({{ $product->stock }} items)</span>
                            @else
                                <span class="px-3 py-1 bg-red-500/20 text-red-400 text-sm rounded-full">Out of Stock</span>
                            @endif
                        </div>
                    @else
                        <p class="mt-4 text-sm text-green-400">Always Available</p>
                    @endif
                </div>

                @if($product->description)
                    <div class="mb-6">
                        <h3 class="text-lg font-bold text-primary mb-3">Description</h3>
                        <p class="text-secondary leading-relaxed">{{ $product->description }}</p>
                    </div>
                @endif

                <!-- Add to Cart Form -->
                @if($product->stock_control && $product->stock < 1)
                    <div class="bg-red-500/10 border border-red-500/20 rounded-xl p-4">
                        <p class="text-sm text-red-400">
                            <strong>Out of Stock:</strong> This product is currently unavailable.
                        </p>
                    </div>
                @else
                    <form action="{{ route('cart.add', $product) }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label for="quantity" class="block text-sm font-medium text-secondary mb-2">Quantity</label>
                            <div class="flex gap-4">
                                <input type="number" id="quantity" name="quantity" value="1" min="1" 
                                    @if($product->stock_control) max="{{ $product->stock }}" @endif
                                    class="w-24 bg-background border border-border rounded-lg px-4 py-3 text-primary text-center focus:ring-1 focus:ring-primary focus:border-primary transition-colors outline-none">
                                <button type="submit" class="flex-1 bg-primary text-background px-8 py-3 rounded-lg font-bold hover:opacity-90 transition-opacity">
                                    Add to Cart
                                </button>
                            </div>
                        </div>
                    </form>
                @endif
            </div>
        </div>

        <!-- Reviews Section -->
        <div class="border-t border-border pt-12">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-primary">Customer Reviews</h2>
                @if($product->review_count > 0)
                    <div class="flex items-center gap-2">
                        <div class="flex">
                            @for($i = 1; $i <= 5; $i++)
                                <span class="{{ $i <= round($product->average_rating) ? 'text-yellow-400' : 'text-secondary' }} text-xl">★</span>
                            @endfor
                        </div>
                        <span class="text-secondary text-sm">({{ $product->review_count }} reviews)</span>
                    </div>
                @endif
            </div>

            <!-- Review Form -->
            <div class="bg-surface border border-border rounded-xl p-6 mb-8">
                <h3 class="font-bold text-primary mb-4">Write a Review</h3>
                <form action="{{ route('reviews.store', $product) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @guest('customer')
                        <input type="text" name="name" placeholder="Your Name" class="w-full bg-background border border-border rounded-lg px-4 py-3 text-primary mb-4" required>
                    @endguest
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-secondary mb-2">Rating *</label>
                        <div class="flex gap-2">
                            @for($i = 1; $i <= 5; $i++)
                                <input type="radio" name="rating" value="{{ $i }}" id="rating{{ $i }}" required class="hidden peer/rating{{ $i }}">
                                <label for="rating{{ $i }}" class="cursor-pointer text-3xl text-secondary peer-checked/rating{{ $i }}:text-yellow-400 hover:text-yellow-400">★</label>
                            @endfor
                        </div>
                    </div>
                    <textarea name="review" rows="4" placeholder="Share your experience..." class="w-full bg-background border border-border rounded-lg px-4 py-3 text-primary mb-4" required></textarea>
                    <input type="file" name="images[]" multiple accept="image/*" class="mb-4">
                    <button type="submit" class

="bg-primary text-background px-6 py-3 rounded-lg font-bold hover:opacity-90">Submit Review</button>
                </form>
            </div>

            <!-- Approved Reviews -->
            <div class="space-y-4">
                @forelse($product->approvedReviews as $review)
                    <div class="bg-surface border border-border rounded-xl p-6">
                        <div class="flex justify-between items-start mb-2">
                            <p class="font-bold text-primary">{{ $review->reviewer_name }}</p>
                            <div class="flex gap-1">
                                @for($i = 1; $i <= 5; $i++)
                                    <span class="{{ $i <= $review->rating ? 'text-yellow-400' : 'text-secondary' }}">★</span>
                                @endfor
                            </div>
                        </div>
                        <p class="text-xs text-secondary mb-3">{{ $review->created_at->format('d M Y') }}</p>
                        <p class="text-primary mb-3">{{ $review->review }}</p>
                        @if($review->images)
                            <div class="flex gap-2 mb-3">
                                @foreach($review->images as $image)
                                    <img src="{{ asset('storage/' . $image) }}" alt="Review" class="w-20 h-20 object-cover rounded">
                                @endforeach
                            </div>
                        @endif
                        <form action="{{ route('reviews.markHelpful', $review) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="text-xs text-secondary hover:text-primary">Helpful ({{ $review->helpful_count }})</button>
                        </form>
                    </div>
                @empty
                    <p class="text-center py-8 text-secondary">No reviews yet. Be the first to review!</p>
                @endforelse
            </div>
        </div>

        <!-- Related Products -->
        @if($relatedProducts->count() > 0)
            <div class="border-t border-border pt-12">
                <h2 class="text-2xl font-bold text-primary mb-8">Related Products</h2>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    @foreach($relatedProducts as $related)
                        <a href="{{ route('products.show', $related) }}" class="bg-surface border border-border rounded-xl overflow-hidden hover:border-primary/50 transition-all duration-300 group">
                            @if($related->images && count($related->images) > 0)
                                <img src="{{ asset('storage/' . $related->images[0]) }}" alt="{{ $related->name }}" class="w-full h-48 object-cover">
                            @else
                                <div class="w-full h-48 bg-secondary/10 flex items-center justify-center text-secondary text-sm">No Image</div>
                            @endif
                            <div class="p-4">
                                <h3 class="font-bold text-primary mb-1 truncate">{{ $related->name }}</h3>
                                <p class="text-lg font-bold text-primary font-mono">Rp {{ number_format($related->price, 0, ',', '.') }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
@endsection
