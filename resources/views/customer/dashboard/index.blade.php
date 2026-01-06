@extends('layouts.public')

@section('title', 'My Dashboard')

@section('content')
    <div class="container mx-auto px-4 py-12">
        <h1 class="text-4xl font-bold text-primary mb-8">My Dashboard</h1>

        <!-- Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-surface border border-border rounded-xl p-6">
                <p class="text-sm text-secondary mb-2">Total Orders</p>
                <p class="text-3xl font-bold text-primary">{{ $stats['total_orders'] }}</p>
            </div>
            <div class="bg-surface border border-border rounded-xl p-6">
                <p class="text-sm text-secondary mb-2">Pending Orders</p>
                <p class="text-3xl font-bold text-yellow-400">{{ $stats['pending_orders'] }}</p>
            </div>
            <div class="bg-surface border border-border rounded-xl p-6">
                <p class="text-sm text-secondary mb-2">Completed</p>
                <p class="text-3xl font-bold text-green-400">{{ $stats['completed_orders'] }}</p>
            </div>
        </div>

        <!-- Quick Links -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
            <a href="{{ route('customer.orders.index') }}" class="bg-surface border border-border rounded-xl p-4 hover:border-primary/50 transition-colors">
                <h3 class="font-bold text-primary">View All Orders</h3>
                <p class="text-sm text-secondary">Track your order history</p>
            </a>
            <a href="{{ route('customer.addresses.index') }}" class="bg-surface border border-border rounded-xl p-4 hover:border-primary/50 transition-colors">
                <h3 class="font-bold text-primary">Manage Addresses</h3>
                <p class="text-sm text-secondary">Update delivery addresses</p>
            </a>
        </div>

        <!-- Recent Orders -->
        <div class="bg-surface border border-border rounded-xl p-6">
            <h2 class="text-xl font-bold text-primary mb-4">Recent Orders</h2>
            @forelse($recentOrders as $order)
                <div class="flex justify-between items-center py-3 border-b border-border last:border-0">
                    <div>
                        <p class="font-mono text-sm text-primary">{{ $order->invoice_code }}</p>
                        <p class="text- xs text-secondary">{{ $order->created_at->format('d M Y H:i') }}</p>
                    </div>
                    <div class="text-right">
                        <p class="font-mono text-primary">Rp {{ number_format($order->amount_total, 0, ',', '.') }}</p>
                        <span class="text-xs px-2 py-1 rounded-full {{ $order->status === 'completed' ? 'bg-green-500/20 text-green-400' : 'bg-yellow-500/20 text-yellow-400' }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>
                </div>
            @empty
                <p class="text-secondary text-center py-8">No orders yet. Start shopping!</p>
            @endforelse
        </div>
    </div>
@endsection
