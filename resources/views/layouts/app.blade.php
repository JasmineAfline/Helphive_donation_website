<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HelpHive</title>
    {{-- Assuming this properly compiles your Tailwind CSS and JavaScript --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-white text-gray-900 antialiased">

    <nav class="sticky top-0 z-50 bg-white/90 backdrop-blur-sm border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center gap-4">
                    <a href="{{ route('home') }}" class="flex items-center gap-3">
                        {{-- Ensure your logo is accessible at the path /images/logo.svg --}}
                        <img src="/images/logo.svg" alt="HelpHive" class="h-10 w-10">
                        <span class="text-lg font-extrabold text-[#2F5D5A]">HelpHive</span>
                    </a>
                </div>

                <div class="hidden md:flex items-center space-x-6">
                    <a href="{{ route('home') }}" class="text-sm font-medium text-gray-700 hover:text-[#E5394D] transition">Home</a>
                    <a href="{{ route('campaigns.index') }}" class="text-sm font-medium text-gray-700 hover:text-[#E5394D] transition">Campaigns</a>
                    <a href="{{ route('about') }}" class="text-sm font-medium text-gray-700 hover:text-[#E5394D] transition">About</a>
                
                    @auth
                        <a href="{{ route('dashboard') }}" class="text-sm font-medium text-gray-700 hover:text-[#E5394D] transition">Dashboard</a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button class="text-sm font-medium text-gray-700 hover:text-[#E5394D] transition">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-medium text-gray-700 hover:text-[#E5394D] transition">Login</a>
                    @endauth
                </div>

                <div class="md:hidden">
                    <button id="mobileMenuBtn" class="p-2 rounded-md text-gray-700 hover:text-[#E5394D] focus:outline-none focus:ring-2 focus:ring-[#E5394D]/30">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <div id="mobileMenu" class="hidden md:hidden border-t border-gray-100">
            <div class="px-4 pt-4 pb-6 space-y-2">
                <a href="{{ route('home') }}" class="block text-gray-700 py-2 hover:text-[#E5394D]">Home</a>
                <a href="{{ route('campaigns.index') }}" class="block text-gray-700 py-2 hover:text-[#E5394D]">Campaigns</a>
                <a href="{{ route('about') }}" class="block text-gray-700 py-2 hover:text-[#E5394D]">About</a>
                @auth
                    <a href="{{ route('dashboard') }}" class="block text-gray-700 py-2 hover:text-[#E5394D]">Dashboard</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="w-full text-left text-gray-700 py-2 hover:text-[#E5394D]">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="block text-gray-700 py-2 hover:text-[#E5394D]">Login</a>
                @endauth
            </div>
        </div>
    </nav>

    <main class="min-h-screen">
        @yield('content')
    </main>

    
    <footer class="bg-gray-800 text-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 border-b border-gray-700 pb-8">
                {{-- Col 1: Brand Info --}}
                <div class="md:col-span-2">
                    <h4 class="text-white font-extrabold text-2xl">HelpHive 🐝</h4>
                    <p class="mt-3 text-sm text-gray-400 max-w-sm">Connecting donors with trusted humanitarian campaigns to create meaningful impact and measurable change globally.</p>
                    <div class="flex items-center gap-4 mt-6">
                        <a href="#" class="p-3 rounded-full bg-white/5 hover:bg-white/10 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="currentColor"><path d="M22 12.07C22 6.48 17.52 2 11.93 2S2 6.48 2 12.07C2 17.07 5.66 21.14 10.44 22v-7.01H8.07v-2.91h2.37V9.64c0-2.34 1.39-3.63 3.52-3.63 1.02 0 1.86.08 2.11.12v2.45h-1.45c-1.14 0-1.36.54-1.36 1.33v1.76h2.72l-.44 2.91h-2.28V22C18.34 21.14 22 17.07 22 12.07z"/></svg>
                        </a>
                        <a href="#" class="p-3 rounded-full bg-white/5 hover:bg-white/10 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="currentColor"><path d="M22.46 6c-.77.35-1.6.59-2.46.7A4.15 4.15 0 0016.88 4c-2.3 0-4.16 1.86-4.16 4.16 0 .33.04.65.11.96C8.4 9.02 5.27 6.8 3 3.77c-.36.62-.57 1.33-.57 2.09 0 1.44.73 2.7 1.84 3.44-.68-.02-1.32-.21-1.89-.52v.05c0 2.01 1.43 3.69 3.33 4.07-.35.1-.73.15-1.11.15-.27 0-.52-.03-.77-.07.53 1.66 2.07 2.86 3.9 2.89A8.36 8.36 0 012 19.54a11.78 11.78 0 006.29 1.84c7.55 0 11.69-6.26 11.69-11.69 0-.18-.01-.36-.02-.53A8.36 8.36 0 0022.46 6z"/></svg>
                        </a>
                        <a href="#" class="p-3 rounded-full bg-white/5 hover:bg-white/10 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.04c-5.5 0-9.96 4.46-9.96 9.96 0 4.4 2.86 8.14 6.83 9.45.5.09.68-.22.68-.48 0-.24-.01-.87-.01-1.71-2.78.61-3.37-1.2-3.37-1.2-.45-1.15-1.11-1.46-1.11-1.46-.91-.62.07-.6.07-.6 1.01.07 1.54 1.04 1.54 1.04.9 1.53 2.36 1.09 2.94.83.09-.65.35-1.09.63-1.34-2.22-.25-4.56-1.11-4.56-4.94 0-1.09.39-1.98 1.03-2.68-.1-.25-.45-1.27.1-2.65 0 0 .84-.27 2.75 1.02A9.54 9.54 0 0112 6.8c.85.004 1.71.115 2.51.337 1.9-1.29 2.74-1.02 2.74-1.02.55 1.38.2 2.4.1 2.65.64.7 1.03 1.6 1.03 2.68 0 3.84-2.35 4.68-4.58 4.93.36.31.68.92.68 1.85 0 1.34-.01 2.42-.01 2.75 0 .26.18.57.69.47 3.96-1.32 6.81-5.06 6.81-9.46 0-5.5-4.46-9.96-9.96-9.96z"/></svg>
                        </a>
                    </div>
                </div>

                {{-- Col 2: Explore Links --}}
                <div>
                    <h5 class="font-bold text-lg text-white">Quick Links</h5>
                    <ul class="mt-4 space-y-3 text-sm text-gray-400">
                        <li><a href="#" class="hover:text-red-400 transition">Active Campaigns</a></li>
                        <li><a href="#" class="hover:text-red-400 transition">How We Operate</a></li>
                        <li><a href="#" class="hover:text-red-400 transition">Financial Reports</a></li>
                        <li><a href="#" class="hover:text-red-400 transition">Volunteer</a></li>
                    </ul>
                </div>

                {{-- Col 3: Support Links --}}
                <div>
                    <h5 class="font-bold text-lg text-white">Support & Legal</h5>
                    <ul class="mt-4 space-y-3 text-sm text-gray-400">
                        <li><a href="#" class="hover:text-red-400 transition">Contact Us</a></li>
                        <li><a href="#" class="hover:text-red-400 transition">FAQs</a></li>
                        <li><a href="#" class="hover:text-red-400 transition">Privacy Policy</a></li>
                        <li><a href="#" class="hover:text-red-400 transition">Terms of Service</a></li>
                    </ul>
                </div>
            </div>

            <div class="mt-8 pt-6 text-center text-sm text-gray-500">
                © {{ date('Y') }} HelpHive. All rights reserved. | Built with ❤️ and Laravel.
            </div>
        </div>
    </footer>


    <script>
        // mobile menu toggle
        document.getElementById('mobileMenuBtn')?.addEventListener('click', function () {
            const menu = document.getElementById('mobileMenu');
            if (!menu) return;
            menu.classList.toggle('hidden');
        });
    </script>

</body>
</html>