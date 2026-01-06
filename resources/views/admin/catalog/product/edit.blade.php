@extends('layouts.admin')

@section('title', 'Edit Product')

@section('content')
    <div class="max-w-4xl">
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-primary mb-2">Edit Product</h2>
            <p class="text-secondary">Update product information</p>
        </div>

        <form action="{{ route('admin.catalog.products.update', $product) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Category -->
                <div>
                    <label for="category_id" class="block text-sm font-medium text-secondary mb-2">Category *</label>
                    <select id="category_id" name="category_id" required
                        class="w-full bg-background border border-border rounded-lg px-4 py-3 text-primary focus:ring-1 focus:ring-primary focus:border-primary transition-colors outline-none">
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- SKU -->
                <div>
                    <label for="sku" class="block text-sm font-medium text-secondary mb-2">SKU *</label>
                    <input id="sku" type="text" name="sku" value="{{ old('sku', $product->sku) }}" required
                        class="w-full bg-background border border-border rounded-lg px-4 py-3 text-primary focus:ring-1 focus:ring-primary focus:border-primary transition-colors outline-none font-mono">
                    @error('sku')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-secondary mb-2">Product Name *</label>
                <input id="name" type="text" name="name" value="{{ old('name', $product->name) }}" required autofocus
                    class="w-full bg-background border border-border rounded-lg px-4 py-3 text-primary focus:ring-1 focus:ring-primary focus:border-primary transition-colors outline-none">
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-medium text-secondary mb-2">Description</label>
                <textarea id="description" name="description" rows="5"
                    class="w-full bg-background border border-border rounded-lg px-4 py-3 text-primary focus:ring-1 focus:ring-primary focus:border-primary transition-colors outline-none">{{ old('description', $product->description) }}</textarea>
                @error('description')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Price -->
                <div>
                    <label for="price" class="block text-sm font-medium text-secondary mb-2">Price (IDR) *</label>
                    <input id="price" type="number" name="price" value="{{ old('price', $product->price) }}" required min="0"
                        class="w-full bg-background border border-border rounded-lg px-4 py-3 text-primary focus:ring-1 focus:ring-primary focus:border-primary transition-colors outline-none font-mono">
                    @error('price')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Stock -->
                <div>
                    <label for="stock" class="block text-sm font-medium text-secondary mb-2">Stock *</label>
                    <input id="stock" type="number" name="stock" value="{{ old('stock', $product->stock) }}" required min="0"
                        class="w-full bg-background border border-border rounded-lg px-4 py-3 text-primary focus:ring-1 focus:ring-primary focus:border-primary transition-colors outline-none font-mono">
                    @error('stock')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Existing Images -->
            @if($product->images && count($product->images) > 0)
                <div>
                    <label class="block text-sm font-medium text-secondary mb-2">Current Images</label>
                    <div class="grid grid-cols-4 gap-4">
                        @foreach($product->images as $image)
                            <div class="relative group">
                                <img src="{{ asset('storage/' . $image) }}" alt="" class="w-full h-24 object-cover rounded-lg border border-border">
                                <label class="absolute top-1 right-1 bg-red-500 text-white text-xs px-2 py-1 rounded cursor-pointer opacity-0 group-hover:opacity-100 transition-opacity">
                                    <input type="checkbox" name="remove_images[]" value="{{ $image }}" class="hidden">
                                    Remove
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- New Images -->
            <div>
                <label for="images" class="block text-sm font-medium text-secondary mb-2">Add New Images</label>
                <input id="images" type="file" name="images[]" multiple accept="image/*"
                    class="w-full bg-background border border-border rounded-lg px-4 py-3 text-primary focus:ring-1 focus:ring-primary focus:border-primary transition-colors outline-none">
                <p class="text-xs text-secondary mt-1">Max 2MB per image. Multiple images allowed.</p>
                @error('images.*')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Checkboxes -->
            <div class="space-y-3">
                <div class="flex items-center">
                    <input id="stock_control" type="checkbox" name="stock_control" value="1" {{ old('stock_control', $product->stock_control) ? 'checked' : '' }}
                        class="rounded border-border text-primary focus:ring-primary">
                    <label for="stock_control" class="ml-2 block text-sm text-secondary">Enable Stock Control</label>
                </div>

                <div class="flex items-center">
                    <input id="is_active" type="checkbox" name="is_active" value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }}
                        class="rounded border-border text-primary focus:ring-primary">
                    <label for="is_active" class="ml-2 block text-sm text-secondary">Active (Visible to Customers)</label>
                </div>
            </div>

            <!-- Meta Info -->
            <div class="bg-surface border border-border rounded-lg p-4">
                <h3 class="text-sm font-bold text-secondary mb-2">Meta Information</h3>
                <div class="space-y-1 text-xs text-secondary">
                    <p><span class="font-medium">Slug:</span> <span class="font-mono">{{ $product->slug }}</span></p>
                    <p><span class="font-medium">Created:</span> {{ $product->created_at->format('d M Y H:i') }}</p>
                    <p><span class="font-medium">Last Updated:</span> {{ $product->updated_at->format('d M Y H:i') }}</p>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex items-center gap-4 pt-4 border-t border-border">
                <button type="submit" class="bg-primary text-background font-bold py-3 px-6 rounded-lg hover:opacity-90 transition-opacity">
                    Update Product
                </button>
                <a href="{{ route('admin.catalog.products.index') }}" class="text-secondary hover:text-primary transition-colors">Cancel</a>
            </div>
        </form>
    </div>
@endsection
