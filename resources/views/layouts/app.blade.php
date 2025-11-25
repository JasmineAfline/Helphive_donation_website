<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HelpHive</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-white text-gray-900">

    <!-- NAVBAR (Appears once) -->
    <nav class="bg-white shadow-md py-4">
        <div class="container mx-auto flex justify-between items-center">
            <a href="{{ route('home') }}" class="text-2xl font-bold text-red-600">HelpHive</a>

            <ul class="flex space-x-6">
                <li><a href="{{ route('home') }}" class="hover:text-red-600">Home</a></li>
                <li><a href="{{ route('campaigns.index') }}" class="hover:text-red-600">Campaigns</a></li>
                <li><a href="{{ route('about') }}" class="hover:text-red-600">About</a></li>

                @auth
                    <li><a href="{{ route('dashboard') }}" class="hover:text-red-600">Dashboard</a></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="hover:text-red-600">Logout</button>
                        </form>
                    </li>
                @else
                    <li><a href="{{ route('login') }}" class="hover:text-red-600">Login</a></li>
                @endauth
            </ul>
        </div>
    </nav>

    <!-- MAIN CONTENT -->
    <main class="min-h-screen">
        @yield('content')
    </main>

    <!-- FOOTER (only if defined) -->
    @hasSection('footer')
        @yield('footer')
    @endif

</body>
</html>
