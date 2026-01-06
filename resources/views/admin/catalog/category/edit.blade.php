@extends('layouts.admin')

@section('title', 'Edit Category')

@section('content')
    <div class="max-w-2xl">
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-primary mb-2">Edit Category</h2>
            <p class="text-secondary">Update category information</p>
        </div>

        <form action="{{ route('admin.catalog.categories.update', $category) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-secondary mb-2">Category Name</label>
                <input id="name" type="text" name="name" value="{{ old('name', $category->name) }}" required autofocus
                    class="w-full bg-background border border-border rounded-lg px-4 py-3 text-primary focus:ring-1 focus:ring-primary focus:border-primary transition-colors outline-none placeholder-secondary">
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-medium text-secondary mb-2">Description</label>
                <textarea id="description" name="description" rows="4"
                    class="w-full bg-background border border-border rounded-lg px-4 py-3 text-primary focus:ring-1 focus:ring-primary focus:border-primary transition-colors outline-none placeholder-secondary">{{ old('description', $category->description) }}</textarea>
                @error('description')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Is Featured -->
            <div class="flex items-center">
                <input id="is_featured" type="checkbox" name="is_featured" value="1" {{ old('is_featured', $category->is_featured) ? 'checked' : '' }}
                    class="rounded border-border text-primary focus:ring-primary">
                <label for="is_featured" class="ml-2 block text-sm text-secondary">Featured Category</label>
            </div>

            <!-- Meta Info -->
            <div class="bg-surface border border-border rounded-lg p-4">
                <h3 class="text-sm font-bold text-secondary mb-2">Meta Information</h3>
                <div class="space-y-1 text-xs text-secondary">
                    <p><span class="font-medium">Slug:</span> <span class="font-mono">{{ $category->slug }}</span></p>
                    <p><span class="font-medium">Products:</span> {{ $category->products()->count() }} items</p>
                    <p><span class="font-medium">Created:</span> {{ $category->created_at->format('d M Y H:i') }}</p>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex items-center gap-4 pt-4">
                <button type="submit" class="bg-primary text-background font-bold py-3 px-6 rounded-lg hover:opacity-90 transition-opacity">
                    Update Category
                </button>
                <a href="{{ route('admin.catalog.categories.index') }}" class="text-secondary hover:text-primary transition-colors">Cancel</a>
            </div>
        </form>
    </div>
@endsection
