@extends('layouts.admin')

@section('title', 'Review Moderation')

@section('content')
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-primary mb-2">Review Moderation</h2>
        <p class="text-secondary">Manage product reviews</p>
    </div>

    <!-- Filter Tabs -->
    <div class="flex gap-2 mb-6">
        <a href="?status=pending" class="px-4 py-2 rounded-lg text-sm {{ $status === 'pending' ? 'bg-primary text-background' : 'bg-surface text-secondary hover:bg-secondary/10' }}">
            Pending
        </a>
        <a href="?status=approved" class="px-4 py-2 rounded-lg text-sm {{ $status === 'approved' ? 'bg-primary text-background' : 'bg-surface text-secondary hover:bg-secondary/10' }}">
            Approved
        </a>
        <a href="?status=rejected" class="px-4 py-2 rounded-lg text-sm {{ $status === 'rejected' ? 'bg-primary text-background' : 'bg-surface text-secondary hover:bg-secondary/10' }}">
            Rejected
        </a>
        <a href="?status=all" class="px-4 py-2 rounded-lg text-sm {{ $status === 'all' ? 'bg-primary text-background' : 'bg-surface text-secondary hover:bg-secondary/10' }}">
            All
        </a>
    </div>

    <div class="space-y-4">
        @forelse($reviews as $review)
            <div class="bg-surface border border-border rounded-xl p-6">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <p class="font-bold text-primary">{{ $review->product->name }}</p>
                        <p class="text-sm text-secondary">by {{ $review->reviewer_name }} • {{ $review->created_at->format('d M Y') }}</p>
                    </div>
                    <div class="flex gap-1">
                        @for($i = 1; $i <= 5; $i++)
                            <span class="{{ $i <= $review->rating ? 'text-yellow-400' : 'text-secondary' }}">★</span>
                        @endfor
                    </div>
                </div>

                <p class="text-primary mb-4">{{ $review->review }}</p>

                @if($review->images)
                    <div class="flex gap-2 mb-4">
                        @foreach($review->images as $image)
                            <img src="{{ asset('storage/' . $image) }}" alt="Review image" class="w-20 h-20 object-cover rounded">
                        @endforeach
                    </div>
                @endif

                <div class="flex gap-2">
                    @if($review->status !== 'approved')
                        <form action="{{ route('admin.reviews.approve', $review) }}" method="POST">
                            @csrf
                            <button type="submit" class="px-4 py-2 bg-green-500/20 text-green-400 rounded-lg text-sm hover:bg-green-500/30">Approve</button>
                        </form>
                    @endif
                    @if($review->status !== 'rejected')
                        <form action="{{ route('admin.reviews.reject', $review) }}" method="POST">
                            @csrf
                            <button type="submit" class="px-4 py-2 bg-red-500/20 text-red-400 rounded-lg text-sm hover:bg-red-500/30">Reject</button>
                        </form>
                    @endif
                    <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST" onsubmit="return confirm('Delete this review?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-red-500/20 text-red-400 rounded-lg text-sm hover:bg-red-500/30">Delete</button>
                    </form>
                </div>
            </div>
        @empty
            <div class="text-center py-12 text-secondary bg-surface border border-border rounded-xl">
                No {{ $status }} reviews found.
            </div>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $reviews->links() }}
    </div>
@endsection
