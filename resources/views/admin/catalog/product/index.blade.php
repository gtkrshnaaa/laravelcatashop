@extends('layouts.admin')

@section('title', 'Products')

@section('content')
    <div class="flex items-center justify-between mb-8">
        <div>
            <h2 class="text-3xl font-bold text-primary mb-2">Products</h2>
            <p class="text-secondary">Manage your product catalog</p>
        </div>
        <a href="{{ route('admin.catalog.products.create') }}" class="bg-primary text-background font-bold py-2 px-4 rounded-lg hover:opacity-90 transition-opacity text-sm">
            + Add Product
        </a>
    </div>

    <div class="bg-surface border border-border rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-all duration-300">
        <table class="w-full text-left">
            <thead>
                <tr class="border-b border-border bg-secondary/5">
                    <th class="px-6 py-4 text-xs font-medium text-secondary uppercase tracking-wider">Product</th>
                    <th class="px-6 py-4 text-xs font-medium text-secondary uppercase tracking-wider">Category</th>
                    <th class="px-6 py-4 text-xs font-medium text-secondary uppercase tracking-wider">Price</th>
                    <th class="px-6 py-4 text-xs font-medium text-secondary uppercase tracking-wider">Stock</th>
                    <th class="px-6 py-4 text-xs font-medium text-secondary uppercase tracking-wider">Status</th>
                    <th class="px-6 py-4 text-xs font-medium text-secondary uppercase tracking-wider text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-border">
                @forelse($products as $product)
                <tr class="hover:bg-primary/5 transition-colors">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            @if($product->images && count($product->images) > 0)
                                <img src="{{ asset('storage/' . $product->images[0]) }}" alt="" class="w-10 h-10 rounded bg-current/5 object-cover">
                            @else
                                <div class="w-10 h-10 rounded bg-current/5 border border-border flex items-center justify-center text-secondary text-xs">No Image</div>
                            @endif
                            <div>
                                <p class="text-primary font-medium">{{ $product->name }}</p>
                                <p class="text-secondary text-xs font-mono">{{ $product->sku }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-secondary text-sm">{{ $product->category->name }}</td>
                    <td class="px-6 py-4 text-secondary text-sm font-mono">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                    <td class="px-6 py-4 text-secondary text-sm">
                        @if($product->stock_control)
                            {{ $product->stock }} items
                        @else
                            <span class="text-xs text-green-400">Always Available</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        @if($product->is_active)
                            <span class="px-2 py-1 rounded-full bg-green-500/20 text-green-400 text-xs font-bold">Active</span>
                        @else
                            <span class="px-2 py-1 rounded-full bg-gray-500/20 text-gray-400 text-xs font-bold">Draft</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right space-x-2">
                        <a href="{{ route('admin.catalog.products.edit', $product) }}" class="text-primary hover:underline text-sm">Edit</a>
                        
                        <form action="{{ route('admin.catalog.products.destroy', $product) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this product?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-400 text-sm">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-8 text-center text-secondary">
                        No products yet. Create your first one!
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $products->links() }}
    </div>
@endsection
