@extends('layouts.public')

@section('title', 'Customer Login')

@section('content')
    <div class="container mx-auto px-4 py-12">
        <div class="max-w-md mx-auto">
            <div class="bg-surface border border-border rounded-xl p-8">
                <h1 class="text-3xl font-bold text-primary mb-6 text-center">Login to Your Account</h1>
                
                <form action="{{ route('customer.login') }}" method="POST">
                    @csrf
                    
                    <div class="space-y-4">
                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-secondary mb-2">Email Address</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                class="w-full bg-background border border-border rounded-lg px-4 py-3 text-primary focus:ring-1 focus:ring-primary focus:border-primary transition-colors outline-none">
                            @error('email')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-secondary mb-2">Password</label>
                            <input type="password" id="password" name="password" required
                                class="w-full bg-background border border-border rounded-lg px-4 py-3 text-primary focus:ring-1 focus:ring-primary focus:border-primary transition-colors outline-none">
                            @error('password')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Remember Me -->
                        <div class="flex items-center">
                            <input type="checkbox" id="remember" name="remember" class="mr-2">
                            <label for="remember" class="text-sm text-secondary">Remember me</label>
                        </div>
                    </div>

                    <button type="submit" class="w-full mt-6 bg-primary text-background px-6 py-3 rounded-lg font-bold hover:opacity-90 transition-opacity">
                        Login
                    </button>
                </form>

                <p class="mt-6 text-center text-sm text-secondary">
                    Don't have an account? 
                    <a href="{{ route('customer.register') }}" class="text-primary hover:underline">Register here</a>
                </p>
            </div>
        </div>
    </div>
@endsection
