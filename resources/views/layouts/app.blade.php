<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Swiss Solidarity')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-red-50 text-gray-800 min-h-screen flex flex-col">

    <!-- Navbar -->
    <nav class="bg-white shadow-md rounded-b-2xl">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <a href="{{ route('home') }}" class="text-2xl font-bold text-red-600">HelpHive</a>
            <ul class="flex space-x-6">
                <li><a href="{{ route('home') }}" class="text-red-600 font-medium hover:text-red-700">Home</a></li>
                <li><a href="{{ route('about') }}" class="text-red-600 font-medium hover:text-red-700">About</a></li>
                <li><a href="{{ route('donate.general') }}" class="text-red-600 font-medium hover:text-red-700">Donate</a></li>
                @auth
                    <li><a href="{{ route('dashboard') }}" class="text-red-600 font-medium hover:text-red-700">Dashboard</a></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-red-600 font-medium hover:text-red-700">Logout</button>
                        </form>
                    </li>
                @else
                    <li><a href="{{ route('login') }}" class="text-red-600 font-medium hover:text-red-700">Login</a></li>
                    <li><a href="{{ route('register') }}" class="text-red-600 font-medium hover:text-red-700">Register</a></li>
                @endauth
            </ul>
        </div>
    </nav>

    <!-- Content -->
    <main class="flex-1 py-10">
        <div class="max-w-7xl mx-auto px-6">
            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white shadow-inner mt-10 rounded-t-2xl">
        <div class="max-w-7xl mx-auto px-6 py-6 flex flex-col md:flex-row justify-between items-center text-sm text-gray-600">
            <p>&copy; 2025 Swiss Solidarity. All rights reserved.</p>
            <div class="flex space-x-4 mt-2 md:mt-0">
                <a href="#" class="hover:text-red-600">Facebook</a>
                <a href="#" class="hover:text-red-600">Twitter</a>
                <a href="#" class="hover:text-red-600">Instagram</a>
            </div>
        </div>
    </footer>

</body>
</html>
