@extends('layouts.admin')

@section('title', 'Transactions')

@section('content')
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-primary mb-2">Transactions</h2>
        <p class="text-secondary">Manage customer orders</p>
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
