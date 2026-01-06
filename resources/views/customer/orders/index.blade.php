@extends('layouts.public')

@section('title', 'My Orders')

@section('content')
    <div class="container mx-auto px-4 py-12">
        <h1 class="text-4xl font-bold text-primary mb-8">My Orders</h1>

        <div class="space-y-4">
            @forelse($orders as $order)
                <div class="bg-surface border border-border rounded-xl p-6">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <p class="font-mono text-lg font-bold text-primary">{{ $order->invoice_code }}</p>
                            <p class="text-sm text-secondary">{{ $order->created_at->format('d M Y, H:i') }}</p>
                        </div>
                        <span class="px-3 py-1 rounded-full text-xs font-bold
                            {{ $order->status === 'unpaid' ? 'bg-yellow-500/20 text-yellow-400' : '' }}
                            {{ $order->status === 'paid' ? 'bg-green-500/20 text-green-400' : '' }}
                            {{ $order->status === 'shipped' ? 'bg-blue-500/20 text-blue-400' : '' }}
                            {{ $order->status === 'completed' ? 'bg-purple-500/20 text-purple-400' : '' }}
                            {{ $order->status === 'cancelled' ? 'bg-red-500/20 text-red-400' : '' }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>

                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-sm text-secondary mb-1">{{ $order->items->count() }} item(s)</p>
                            <p class="text-2xl font-bold text-primary font-mono">Rp {{ number_format($order->amount_total, 0, ',', '.') }}</p>
                        </div>
                        <a href="{{ route('customer.orders.show', $order) }}" class="text-primary hover:underline text-sm">View Details →</a>
                    </div>
                </div>
            @empty
                <div class="text-center py-12 text-secondary">
                    <p class="mb-4">You haven't placed any orders yet.</p>
                    <a href="{{ route('catalog.index') }}" class="bg-primary text-background px-6 py-3 rounded-lg font-bold hover:opacity-90 transition-opacity inline-block">
                        Start Shopping
                    </a>
                </div>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $orders->links() }}
        </div>
    </div>
@endsection
