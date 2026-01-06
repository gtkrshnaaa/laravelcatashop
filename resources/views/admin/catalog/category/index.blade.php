@extends('layouts.admin')

@section('title', 'Categories')

@section('content')
    <div class="flex items-center justify-between mb-8">
        <div>
            <h2 class="text-3xl font-bold text-primary mb-2">Categories</h2>
            <p class="text-secondary">Manage product categories</p>
        </div>
        <a href="{{ route('admin.catalog.categories.create') }}" class="bg-primary text-background font-bold py-2 px-4 rounded-lg hover:opacity-90 transition-opacity text-sm">
            + Add Category
        </a>
    </div>

    <div class="bg-surface border border-border rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-all duration-300">
        <table class="w-full text-left">
            <thead>
                <tr class="border-b border-border bg-secondary/5">
                    <th class="px-6 py-4 text-xs font-medium text-secondary uppercase tracking-wider">Name</th>
                    <th class="px-6 py-4 text-xs font-medium text-secondary uppercase tracking-wider">Slug</th>
                    <th class="px-6 py-4 text-xs font-medium text-secondary uppercase tracking-wider">Products</th>
                    <th class="px-6 py-4 text-xs font-medium text-secondary uppercase tracking-wider">Featured</th>
                    <th class="px-6 py-4 text-xs font-medium text-secondary uppercase tracking-wider text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-border">
                @forelse($categories as $category)
                <tr class="hover:bg-primary/5 transition-colors">
                    <td class="px-6 py-4 text-primary font-medium">{{ $category->name }}</td>
                    <td class="px-6 py-4 text-secondary text-sm font-mono">{{ $category->slug }}</td>
                    <td class="px-6 py-4 text-secondary text-sm">{{ $category->products_count }} items</td>
                    <td class="px-6 py-4">
                        @if($category->is_featured)
                            <span class="px-2 py-1 rounded-full bg-yellow-500/20 text-yellow-400 text-xs font-bold">Featured</span>
                        @else
                            <span class="text-secondary text-xs">No</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right space-x-2">
                        <a href="{{ route('admin.catalog.categories.edit', $category) }}" class="text-primary hover:underline text-sm">Edit</a>
                        
                        <form action="{{ route('admin.catalog.categories.destroy', $category) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this category?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-400 text-sm">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-8 text-center text-secondary">
                        No categories yet. Create your first one!
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $categories->links() }}
    </div>
@endsection
