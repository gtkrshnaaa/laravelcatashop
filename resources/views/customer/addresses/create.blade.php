@extends('layouts.public')

@section('title', 'Add Address')

@section('content')
    <div class="container mx-auto px-4 py-12">
        <div class="max-w-2xl mx-auto">
            <h1 class="text-4xl font-bold text-primary mb-8">Add New Address</h1>

            <form action="{{ route('customer.addresses.store') }}" method="POST" class="bg-surface border border-border rounded-xl p-6">
                @csrf

                <div class="space-y-4">
                    <div>
                        <label for="label" class="block text-sm font-medium text-secondary mb-2">Label (e.g., Home, Office) *</label>
                        <input type="text" id="label" name="label" value="{{ old('label') }}" required
                            class="w-full bg-background border border-border rounded-lg px-4 py-3 text-primary focus:ring-1 focus:ring-primary focus:border-primary transition-colors outline-none">
                        @error('label')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="address" class="block text-sm font-medium text-secondary mb-2">Full Address *</label>
                        <textarea id="address" name="address" rows="4" required
                            class="w-full bg-background border border-border rounded-lg px-4 py-3 text-primary focus:ring-1 focus:ring-primary focus:border-primary transition-colors outline-none">{{ old('address') }}</textarea>
                        @error('address')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" id="is_default" name="is_default" value="1" {{ old('is_default') ? 'checked' : '' }} class="mr-2">
                        <label for="is_default" class="text-sm text-secondary">Set as default address</label>
                    </div>
                </div>

                <div class="flex gap-4 mt-6">
                    <button type="submit" class="flex-1 bg-primary text-background px-6 py-3 rounded-lg font-bold hover:opacity-90 transition-opacity">
                        Save Address
                    </button>
                    <a href="{{ route('customer.addresses.index') }}" class="flex-1 border border-border text-center px-6 py-3 rounded-lg font-bold hover:border-primary/50 transition-colors">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
