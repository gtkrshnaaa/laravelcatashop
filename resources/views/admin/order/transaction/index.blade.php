@extends('layouts.admin')

@section('title', 'Transactions')

@section('content')
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-primary mb-2">Transactions</h2>
        <p class="text-secondary">Manage customer orders</p>
    </div>

    <!-- Filter Bar -->
    <div class="bg-surface border border-border rounded-xl p-6 mb-6 space-y-4">
        <!-- Search -->
        <form action="{{ route('admin.order.transactions.index') }}" method="GET" class="flex gap-4">
            <div class="flex-1 relative">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 absolute left-3 top-2.5 text-secondary">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                </svg>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by invoice code or customer name..."
                    class="w-full bg-background border border-border rounded-lg pl-10 pr-4 py-2 text-primary focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all text-sm">
            </div>
            @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif
            <button type="submit" class="bg-primary text-background px-6 py-2 rounded-lg font-medium text-sm hover:opacity-90 transition-opacity">
                Search
            </button>
            @if(request('search') || request('status'))
                <a href="{{ route('admin.order.transactions.index') }}" class="px-6 py-2 rounded-lg border border-border text-secondary hover:text-primary hover:bg-surface transition-colors text-sm">
                    Clear Filters
                </a>
            @endif
        </form>

        <!-- Status Filter Tabs -->
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('admin.order.transactions.index', array_filter(['search' => request('search')])) }}" 
                class="px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ !request('status') ? 'bg-primary text-background' : 'bg-background text-secondary hover:text-primary' }}">
                All ({{ $statusCounts['all'] }})
            </a>
            <a href="{{ route('admin.order.transactions.index', array_filter(['status' => 'unpaid', 'search' => request('search')])) }}" 
                class="px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ request('status') === 'unpaid' ? 'bg-yellow-500/20 text-yellow-400 border border-yellow-500/50' : 'bg-background text-secondary hover:text-primary' }}">
                Unpaid ({{ $statusCounts['unpaid'] }})
            </a>
            <a href="{{ route('admin.order.transactions.index', array_filter(['status' => 'paid', 'search' => request('search')])) }}" 
                class="px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ request('status') === 'paid' ? 'bg-green-500/20 text-green-400 border border-green-500/50' : 'bg-background text-secondary hover:text-primary' }}">
                Paid ({{ $statusCounts['paid'] }})
            </a>
            <a href="{{ route('admin.order.transactions.index', array_filter(['status' => 'shipped', 'search' => request('search')])) }}" 
                class="px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ request('status') === 'shipped' ? 'bg-blue-500/20 text-blue-400 border border-blue-500/50' : 'bg-background text-secondary hover:text-primary' }}">
                Shipped ({{ $statusCounts['shipped'] }})
            </a>
            <a href="{{ route('admin.order.transactions.index', array_filter(['status' => 'completed', 'search' => request('search')])) }}" 
                class="px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ request('status') === 'completed' ? 'bg-purple-500/20 text-purple-400 border border-purple-500/50' : 'bg-background text-secondary hover:text-primary' }}">
                Completed ({{ $statusCounts['completed'] }})
            </a>
            <a href="{{ route('admin.order.transactions.index', array_filter(['status' => 'cancelled', 'search' => request('search')])) }}" 
                class="px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ request('status') === 'cancelled' ? 'bg-red-500/20 text-red-400 border border-red-500/50' : 'bg-background text-secondary hover:text-primary' }}">
                Cancelled ({{ $statusCounts['cancelled'] }})
            </a>
        </div>

        <!-- Active Filters Summary -->
        @if(request('search') || request('status'))
            <div class="flex items-center gap-2 text-sm text-secondary">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 01-.659 1.591l-5.432 5.432a2.25 2.25 0 00-.659 1.591v2.927a2.25 2.25 0 01-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 00-.659-1.591L3.659 7.409A2.25 2.25 0 013 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0112 3z" />
                </svg>
                Showing {{ $transactions->total() }} result(s)
            </div>
        @endif
    </div>

    <div class="bg-surface border border-border rounded-xl overflow-hidden shadow-sm">
        <table class="w-full text-left">
            <thead>
                <tr class="border-b border-border bg-secondary/5">
                    <th class="px-6 py-4 text-xs font-medium text-secondary uppercase tracking-wider">Invoice</th>
                    <th class="px-6 py-4 text-xs font-medium text-secondary uppercase tracking-wider">Customer</th>
                    <th class="px-6 py-4 text-xs font-medium text-secondary uppercase tracking-wider">Amount</th>
                    <th class="px-6 py-4 text-xs font-medium text-secondary uppercase tracking-wider">Payment</th>
                    <th class="px-6 py-4 text-xs font-medium text-secondary uppercase tracking-wider">Status</th>
                    <th class="px-6 py-4 text-xs font-medium text-secondary uppercase tracking-wider">Date</th>
                    <th class="px-6 py-4 text-xs font-medium text-secondary uppercase tracking-wider text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-border">
                @forelse($transactions as $transaction)
                <tr class="hover:bg-primary/5 transition-colors">
                    <td class="px-6 py-4">
                        <p class="font-mono text-xs text-primary">{{ $transaction->invoice_code }}</p>
                    </td>
                    <td class="px-6 py-4">
                        <p class="text-sm font-medium text-primary">{{ $transaction->customer_info['name'] }}</p>
                        <p class="text-xs text-secondary">{{ $transaction->customer_info['whatsapp'] }}</p>
                    </td>
                    <td class="px-6 py-4">
                        <p class="font-mono text-sm text-primary">Rp {{ number_format($transaction->amount_total, 0, ',', '.') }}</p>
                    </td>
                    <td class="px-6 py-4 text-xs text-secondary">{{ ucfirst(str_replace('_', ' ', $transaction->payment_method)) }}</td>
                    <td class="px-6 py-4">
                        @if($transaction->status === 'unpaid')
                            <span class="px-2 py-1 rounded-full bg-yellow-500/20 text-yellow-400 text-xs font-bold">Unpaid</span>
                        @elseif($transaction->status === 'paid')
                            <span class="px-2 py-1 rounded-full bg-green-500/20 text-green-400 text-xs font-bold">Paid</span>
                        @elseif($transaction->status === 'shipped')
                            <span class="px-2 py-1 rounded-full bg-blue-500/20 text-blue-400 text-xs font-bold">Shipped</span>
                        @elseif($transaction->status === 'completed')
                            <span class="px-2 py-1 rounded-full bg-purple-500/20 text-purple-400 text-xs font-bold">Completed</span>
                        @else
                            <span class="px-2 py-1 rounded-full bg-red-500/20 text-red-400 text-xs font-bold">Cancelled</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-xs text-secondary">{{ $transaction->created_at->format('d M Y H:i') }}</td>
                    <td class="px-6 py-4 text-right">
                        <a href="{{ route('admin.order.transactions.show', $transaction) }}" class="text-primary hover:underline text-sm">View</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-8 text-center text-secondary">
                        No transactions yet.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $transactions->links() }}
    </div>
@endsection
