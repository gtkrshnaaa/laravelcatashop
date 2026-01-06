@extends('layouts.public')

@section('title', 'My Addresses')

@section('content')
    <div class="container mx-auto px-4 py-12">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-4xl font-bold text-primary">My Addresses</h1>
            <a href="{{ route('customer.addresses.create') }}" class="bg-primary text-background px-6 py-3 rounded-lg font-bold hover:opacity-90 transition-opacity">
                Add New Address
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @forelse($addresses as $address)
                <div class="bg-surface border border-border rounded-xl p-6 relative">
                    @if($address->is_default)
                        <span class="absolute top-4 right-4 px-3 py-1 bg-green-500/20 text-green-400 text-xs font-bold rounded-full">Default</span>
                    @endif

                    <h3 class="font-bold text-primary text-lg mb-2">{{ $address->label }}</h3>
                    <p class="text-secondary text-sm mb-4">{{ $address->address }}</p>

                    <div class="flex gap-2">
                        @if(!$address->is_default)
                            <form action="{{ route('customer.addresses.setDefault', $address) }}" method="POST">
                                @csrf
                                <button type="submit" class="text-sm text-primary hover:underline">Set Default</button>
                            </form>
                        @endif
                        <a href="{{ route('customer.addresses.edit', $address) }}" class="text-sm text-primary hover:underline">Edit</a>
                        <form action="{{ route('customer.addresses.destroy', $address) }}" method="POST" onsubmit="return confirm('Delete this address?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-sm text-red-500 hover:underline">Delete</button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="col-span-2 text-center py-12 text-secondary bg-surface border border-border rounded-xl">
                    <p class="mb-4">No addresses saved yet.</p>
                    <a href="{{ route('customer.addresses.create') }}" class="bg-primary text-background px-6 py-3 rounded-lg font-bold hover:opacity-90 transition-opacity inline-block">
                        Add Your First Address
                    </a>
                </div>
            @endforelse
        </div>
    </div>
@endsection
