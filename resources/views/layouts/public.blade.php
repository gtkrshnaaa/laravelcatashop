<!DOCTYPE html>
<html lang="en" x-data="{
    theme: localStorage.getItem('theme') || 'dark',
    toggleTheme() {
        this.theme = this.theme === 'dark' ? 'light' : 'dark';
        localStorage.setItem('theme', this.theme);
        if (this.theme === 'dark') {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    },
    init() {
        if (this.theme === 'dark') {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    }
}" x-init="init()" :class="theme">
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('wishlist', () => ({ 
            async toggle(productId, buttonElement) {
                @guest('customer')
                    window.location.href = "{{ route('customer.login') }}";
                    return;
                @endguest

                try {
                    const response = await fetch("{{ route('wishlist.toggle') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({ product_id: productId })
                    });
                    
                    if (response.status === 401) {
                         window.location.href = "{{ route('customer.login') }}";
                         return;
                    }

                    const data = await response.json();
                    
                    // Dispatch custom event for UI updates
                    window.dispatchEvent(new CustomEvent('wishlist-updated', { 
                        detail: { productId: productId, status: data.status } 
                    }));

                } catch (error) {
                    console.error('Error toggling wishlist:', error);
                }
            }
        }))
    })
</script>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'LaravelCataShop') - Simple E-Commerce Solution</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark')
        } else {
            document.documentElement.classList.remove('dark')
        }
    </script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        background: 'var(--background)',
                        surface: 'var(--surface)',
                        border: 'var(--border)',
                        primary: 'var(--primary)',
                        secondary: 'var(--secondary)',
                        accent: 'var(--accent)',
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        mono: ['JetBrains Mono', 'monospace'],
                    }
                }
            }
        }
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    <style>
        :root {
            --background: #ffffff;
            --surface: #ffffff;
            --border: #e4e4e7;
            --primary: #18181b;
            --secondary: #71717a;
            --accent: #000000;
        }

        .dark {
            --background: #0a0a0a;
            --surface: #171717;
            --border: #262626;
            --primary: #ededed;
            --secondary: #a1a1aa;
            --accent: #ffffff;
        }

        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-background text-primary min-h-screen flex flex-col transition-colors duration-300">
    
    <!-- Navbar -->
    <nav class="border-b border-border bg-background/80 backdrop-blur-md sticky top-0 z-50" x-data="{ mobileMenuOpen: false }">
        <div class="container mx-auto px-4 h-16 flex items-center justify-between">
            <!-- Logo -->
            <a href="{{ route('home') }}" class="text-xl font-bold tracking-tighter text-primary">CATASHOP</a>

            <!-- Desktop Menu -->
            <div class="hidden md:flex items-center gap-8">
                <a href="{{ route('home') }}" class="text-sm font-medium {{ request()->routeIs('home') ? 'text-primary' : 'text-secondary hover:text-primary' }} transition-colors">Home</a>
                <a href="{{ route('catalog.index') }}" class="text-sm font-medium transition-colors hover:text-primary {{ request()->routeIs('catalog.*') ? 'text-primary' : 'text-secondary' }}">Catalog</a>
                <a href="{{ route('cart.index') }}" class="text-sm font-medium transition-colors hover:text-primary {{ request()->routeIs('cart.*') ? 'text-primary' : 'text-secondary' }}">Cart</a>
                
                @auth('customer')
                    <a href="{{ route('customer.dashboard') }}" class="text-sm font-medium transition-colors hover:text-primary {{ request()->routeIs('customer.dashboard') ? 'text-primary' : 'text-secondary' }}">My Account</a>
                    <form action="{{ route('customer.logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-sm font-medium text-secondary hover:text-primary transition-colors">Logout</button>
                    </form>
                @else
                    <a href="{{ route('customer.login') }}" class="text-sm font-medium transition-colors hover:text-primary {{ request()->routeIs('customer.login') ? 'text-primary' : 'text-secondary' }}">Login</a>
                    <a href="{{ route('customer.register') }}" class="text-sm font-medium transition-colors hover:text-primary {{ request()->routeIs('customer.register') ? 'text-primary' : 'text-secondary' }}">Register</a>
                @endauth
                
                <!-- Theme Toggle -->
                <button @click="toggleTheme()" class="text-secondary hover:text-primary transition-colors">
                    <svg x-show="theme === 'dark'" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" />
                    </svg>
                    <svg x-show="theme === 'light'" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.718 9.718 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 009.002-5.998z" />
                    </svg>
                </button>
            </div>

            <!-- Mobile Menu Button -->
            <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden text-primary p-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
            </button>
        </div>

        <!-- Mobile Menu -->
        <div 
            x-show="mobileMenuOpen" 
            x-transition
            @click.away="mobileMenuOpen = false" 
            class="md:hidden absolute top-16 left-0 w-full bg-background border-b border-border p-4 flex flex-col gap-4 shadow-2xl"
        >
            <a href="{{ route('home') }}" class="text-sm font-medium {{ request()->routeIs('home') ? 'text-primary' : 'text-secondary hover:text-primary' }} transition-colors py-2">Home</a>
            <a href="{{ route('catalog.index') }}" class="text-sm font-medium {{ request()->routeIs('catalog.*') ? 'text-primary' : 'text-secondary hover:text-primary' }} transition-colors py-2">Catalog</a>
            <a href="{{ route('cart.index') }}" class="text-sm font-medium {{ request()->routeIs('cart.*') ? 'text-primary' : 'text-secondary hover:text-primary' }} transition-colors py-2">Cart</a>
            
            @auth('customer')
                <a href="{{ route('customer.dashboard') }}" class="text-sm font-medium {{ request()->routeIs('customer.dashboard') ? 'text-primary' : 'text-secondary hover:text-primary' }} transition-colors py-2">My Account</a>
                <form action="{{ route('customer.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="text-sm font-medium text-secondary hover:text-primary transition-colors py-2 text-left w-full">Logout</button>
                </form>
            @else
                <a href="{{ route('customer.login') }}" class="text-sm font-medium {{ request()->routeIs('customer.login') ? 'text-primary' : 'text-secondary hover:text-primary' }} transition-colors py-2">Login</a>
                <a href="{{ route('customer.register') }}" class="text-sm font-medium {{ request()->routeIs('customer.register') ? 'text-primary' : 'text-secondary hover:text-primary' }} transition-colors py-2">Register</a>
            @endauth
            
            <div class="flex items-center justify-between pt-2 border-t border-border">
                <span class="text-xs font-mono text-secondary">Theme</span>
                <button @click="toggleTheme()" class="text-secondary hover:text-primary transition-colors">
                    <svg x-show="theme === 'dark'" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" />
                    </svg>
                    <svg x-show="theme === 'light'" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.718 9.718 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 009.002-5.998z" />
                    </svg>
                </button>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-1">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="border-t border-border bg-surface py-12">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-lg font-bold tracking-tighter text-primary mb-4">CATASHOP</h2>
            <div class="flex justify-center gap-6 mb-8 text-sm text-secondary">
                <a href="{{ route('catalog.index') }}" class="hover:text-primary transition-colors">Browse Catalog</a>
                <a href="{{ route('admin.login') }}" class="hover:text-primary transition-colors">Admin Login</a>
            </div>
            <p class="text-xs text-secondary/70">
                &copy; {{ date('Y') }} LaravelCataShop. Simple E-Commerce Solution.
            </p>
        </div>
    </footer>
</body>
</html>
