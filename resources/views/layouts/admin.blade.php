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
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') - LaravelCataShop</title>
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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    <style>
        :root {
            /* Light Mode */
            --background: #ffffff;
            --surface: #ffffff;
            --border: #e4e4e7;
            --primary: #18181b;
            --secondary: #71717a;
            --accent: #000000;
        }

        .dark {
            /* Dark Mode */
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
<body class="bg-background text-primary min-h-screen flex">
    
    <!-- Sidebar -->
    <aside class="w-64 bg-background border-r border-border flex-shrink-0 flex flex-col justify-between hidden md:flex sticky top-0 h-screen overflow-y-auto">
        <div class="p-6">
            <div class="flex items-center justify-between mb-8">
                <h1 class="text-xl font-bold tracking-tighter text-primary">CATASHOP</h1>
                <button @click="toggleTheme()" class="text-secondary hover:text-primary transition-colors">
                    <svg x-show="theme === 'dark'" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" />
                    </svg>
                    <svg x-show="theme === 'light'" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.718 9.718 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 009.002-5.998z" />
                    </svg>
                </button>
            </div>
            
            <nav class="space-y-1">
                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('admin.dashboard') ? 'bg-primary text-background' : 'text-secondary hover:text-primary hover:bg-secondary/10' }} transition-colors">
                    Dashboard
                </a>

                <div class="pt-4 pb-2">
                    <p class="px-4 text-xs font-bold text-secondary uppercase tracking-wider">Catalog</p>
                </div>

                <a href="{{ route('admin.catalog.categories.index') }}" class="block px-4 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('admin.catalog.categories.*') ? 'bg-primary text-background' : 'text-secondary hover:text-primary hover:bg-secondary/10' }} transition-colors">
                    Categories
                </a>
                <a href="{{ route('admin.catalog.products.index') }}" class="block px-4 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('admin.catalog.products.*') ? 'bg-primary text-background' : 'text-secondary hover:text-primary hover:bg-secondary/10' }} transition-colors">
                    Products
                </a>

                <div class="pt-4 pb-2">
                    <p class="px-4 text-xs font-bold text-secondary uppercase tracking-wider">Orders</p>
                </div>

                <a href="{{ route('admin.order.transactions.index') }}" class="block px-4 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('admin.order.transactions.*') ? 'bg-primary text-background' : 'text-secondary hover:text-primary hover:bg-secondary/10' }} transition-colors">
                    Transactions
                </a>
            </nav>
        </div>

        <div class="p-6 border-t border-border">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-8 h-8 rounded-full bg-surface flex items-center justify-center text-xs font-bold">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
                <div>
                    <p class="text-sm font-medium text-primary">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-secondary">Admin</p>
                </div>
            </div>
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit" class="w-full text-left px-0 text-red-500 text-xs hover:text-red-400 transition-colors">
                    Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col min-w-0 overflow-hidden">
        
        <!-- Mobile Header -->
        <header class="md:hidden bg-background border-b border-border p-4 flex items-center justify-between">
             <h1 class="text-lg font-bold tracking-tighter text-primary">CATASHOP</h1>
             <div class="flex items-center gap-4">
                <button @click="toggleTheme()" class="text-secondary hover:text-primary transition-colors">
                    <svg x-show="theme === 'dark'" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" />
                    </svg>
                    <svg x-show="theme === 'light'" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.718 9.718 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 009.002-5.998z" />
                    </svg>
                </button>
             </div>
        </header>

        <div class="flex-1 overflow-auto p-6 md:p-12">
            @if(session('success'))
                <div class="mb-6 bg-green-900/30 border border-green-900 text-green-300 px-4 py-3 rounded-lg text-sm" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 bg-red-900/30 border border-red-900 text-red-300 px-4 py-3 rounded-lg text-sm" role="alert">
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </div>
    </main>

</body>
</html>
