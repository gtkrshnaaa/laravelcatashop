@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-primary mb-2">Dashboard</h2>
        <p class="text-secondary">Welcome to LaravelCataShop Admin Panel</p>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Widget 1 -->
        <div class="bg-surface border border-border p-6 rounded-xl relative overflow-hidden group hover:border-primary/20 shadow-sm hover:shadow-md transition-all duration-300">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-blue-500/10 rounded-full blur-2xl group-hover:bg-blue-500/20 transition-colors"></div>
            <h3 class="text-secondary text-xs uppercase tracking-widest font-bold mb-2">Total Products</h3>
            <div class="flex items-end gap-2">
                <p class="text-4xl font-bold text-primary font-mono">{{ $metrics['total_products'] }}</p>
                <span class="text-xs text-green-400 mb-1">Items</span>
            </div>
        </div>

        <!-- Widget 2 -->
        <div class="bg-surface border border-border p-6 rounded-xl relative overflow-hidden group hover:border-primary/20 shadow-sm hover:shadow-md transition-all duration-300">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-purple-500/10 rounded-full blur-2xl group-hover:bg-purple-500/20 transition-colors"></div>
            <h3 class="text-secondary text-xs uppercase tracking-widest font-bold mb-2">Categories</h3>
            <div class="flex items-end gap-2">
                <p class="text-4xl font-bold text-primary font-mono">{{ $metrics['total_categories'] }}</p>
                <span class="text-xs text-purple-400 mb-1">Tags</span>
            </div>
        </div>

        <!-- Widget 3 -->
        <div class="bg-surface border border-border p-6 rounded-xl relative overflow-hidden group hover:border-primary/20 shadow-sm hover:shadow-md transition-all duration-300">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-green-500/10 rounded-full blur-2xl group-hover:bg-green-500/20 transition-colors"></div>
            <h3 class="text-secondary text-xs uppercase tracking-widest font-bold mb-2">Total Orders</h3>
            <div class="flex items-end gap-2">
                <p class="text-4xl font-bold text-primary font-mono">{{ $metrics['total_transactions'] }}</p>
                <span class="text-xs text-secondary mb-1">Transactions</span>
            </div>
        </div>

        <!-- Widget 4 -->
        <div class="bg-surface border border-border p-6 rounded-xl relative overflow-hidden group hover:border-primary/20 shadow-sm hover:shadow-md transition-all duration-300">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-yellow-500/10 rounded-full blur-2xl group-hover:bg-yellow-500/20 transition-colors"></div>
            <h3 class="text-secondary text-xs uppercase tracking-widest font-bold mb-2">Pending Orders</h3>
            <div class="flex items-end gap-2">
                <p class="text-4xl font-bold text-primary font-mono">{{ $metrics['pending_transactions'] }}</p>
                <span class="text-xs text-yellow-500 mb-1">Awaiting Payment</span>
            </div>
        </div>
    </div>

    <!-- Revenue Card -->
    <div class="bg-gradient-to-br from-blue-600 to-purple-600 p-6 rounded-xl mb-8 shadow-lg">
        <h3 class="text-white/90 text-xs uppercase tracking-widest font-bold mb-2">Total Revenue</h3>
        <div class="flex items-end gap-2">
            <p class="text-5xl font-bold text-white font-mono">Rp {{ number_format($metrics['total_revenue'], 0, ',', '.') }}</p>
        </div>
        <p class="text-white/70 text-sm mt-2">All completed transactions</p>
    </div>

    <!-- Recent Orders -->
    <div class="bg-surface border border-border rounded-xl overflow-hidden shadow-sm">
        <div class="p-6 border-b border-border">
            <h3 class="text-primary font-bold flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 h-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                Recent Orders
            </h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-xs text-secondary uppercase bg-secondary/5">
                    <tr>
                        <th class="px-6 py-3">Invoice Code</th>
                        <th class="px-6 py-3">Customer</th>
                        <th class="px-6 py-3">Amount</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3">Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border">
                    @forelse($recentOrders as $order)
                    <tr class="hover:bg-primary/5 transition-colors">
                        <td class="px-6 py-4 font-mono text-xs">{{ $order->invoice_code }}</td>
                        <td class="px-6 py-4 text-primary">{{ $order->customer_info['name'] ?? 'N/A' }}</td>
                        <td class="px-6 py-4 font-mono">Rp {{ number_format($order->amount_total, 0, ',', '.') }}</td>
                        <td class="px-6 py-4">
                            @if($order->status === 'unpaid')
                                <span class="px-2 py-1 rounded-full bg-yellow-500/20 text-yellow-400 text-xs font-bold">Unpaid</span>
                            @elseif($order->status === 'paid')
                                <span class="px-2 py-1 rounded-full bg-green-500/20 text-green-400 text-xs font-bold">Paid</span>
                            @elseif($order->status === 'shipped')
                                <span class="px-2 py-1 rounded-full bg-blue-500/20 text-blue-400 text-xs font-bold">Shipped</span>
                            @elseif($order->status === 'completed')
                                <span class="px-2 py-1 rounded-full bg-purple-500/20 text-purple-400 text-xs font-bold">Completed</span>
                            @else
                                <span class="px-2 py-1 rounded-full bg-red-500/20 text-red-400 text-xs font-bold">{{ ucfirst($order->status) }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-secondary">{{ $order->created_at->diffForHumans() }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-secondary">No orders yet</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
