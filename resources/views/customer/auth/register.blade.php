@extends('layouts.public')

@section('title', 'Customer Registration')

@section('content')
    <div class="container mx-auto px-4 py-12">
        <div class="max-w-md mx-auto">
            <div class="bg-surface border border-border rounded-xl p-8">
                <h1 class="text-3xl font-bold text-primary mb-6 text-center">Create Account</h1>
                
                <form action="{{ route('customer.register') }}" method="POST">
                    @csrf
                    
                    <div class="space-y-4">
                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-secondary mb-2">Full Name *</label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" required
                                class="w-full bg-background border border-border rounded-lg px-4 py-3 text-primary focus:ring-1 focus:ring-primary focus:border-primary transition-colors outline-none">
                            @error('name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-secondary mb-2">Email Address *</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                class="w-full bg-background border border-border rounded-lg px-4 py-3 text-primary focus:ring-1 focus:ring-primary focus:border-primary transition-colors outline-none">
                            @error('email')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- WhatsApp -->
                        <div>
                            <label for="whatsapp" class="block text-sm font-medium text-secondary mb-2">WhatsApp Number *</label>
                            <input type="text" id="whatsapp" name="whatsapp" value="{{ old('whatsapp') }}" placeholder="08123456789" required
                                class="w-full bg-background border border-border rounded-lg px-4 py-3 text-primary focus:ring-1 focus:ring-primary focus:border-primary transition-colors outline-none">
                            @error('whatsapp')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-secondary mb-2">Password *</label>
                            <input type="password" id="password" name="password" required
                                class="w-full bg-background border border-border rounded-lg px-4 py-3 text-primary focus:ring-1 focus:ring-primary focus:border-primary transition-colors outline-none">
                            @error('password')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-secondary mb-2">Confirm Password *</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" required
                                class="w-full bg-background border border-border rounded-lg px-4 py-3 text-primary focus:ring-1 focus:ring-primary focus:border-primary transition-colors outline-none">
                        </div>
                    </div>

                    <button type="submit" class="w-full mt-6 bg-primary text-background px-6 py-3 rounded-lg font-bold hover:opacity-90 transition-opacity">
                        Create Account
                    </button>
                </form>

                <p class="mt-6 text-center text-sm text-secondary">
                    Already have an account? 
                    <a href="{{ route('customer.login') }}" class="text-primary hover:underline">Login here</a>
                </p>
            </div>
        </div>
    </div>
@endsection
