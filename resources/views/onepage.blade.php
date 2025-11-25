@extends('layouts.app')

@section('content')

<nav class="bg-red-600 text-white py-4 fixed w-full top-0 shadow z-50">
    <div class="container mx-auto flex justify-between items-center">
        <h1 class="font-bold text-2xl">HelpHive</h1>
        <div class="space-x-6">
            <a href="#home" class="hover:text-gray-200">Home</a>
            <a href="#about" class="hover:text-gray-200">Campaigns</a>
            <a href="#donate" class="hover:text-gray-200">About</a>
            <a href="#contact" class="hover:text-gray-200">Contact</a>
        </div>
    </div>
</nav>

<!-- HOME SECTION -->
<section id="home" class="h-screen flex items-center justify-center bg-white">
    <div class="text-center max-w-2xl">
        <h2 class="text-5xl font-bold text-red-600 mb-4">Welcome to HelpHive</h2>
        <p class="text-xl mb-6">Donate, volunteer, and spread hope to communities in need.</p>
        <a href="#donate" class="bg-red-600 text-white px-6 py-3 rounded-full hover:bg-red-700 transition">
            Donate Now
        </a>
    </div>
</section>

<!-- ABOUT SECTION -->
<section id="about" class="h-screen flex items-center justify-center bg-red-50">
    <div class="text-center max-w-2xl">
        <h2 class="text-4xl font-bold text-red-600 mb-4">About Us</h2>
        <p class="text-lg">
            HelpHive is dedicated to supporting emergency medical aid for children in need.
        </p>
    </div>
</section>

<!-- DONATE SECTION -->
<section id="donate" class="h-screen flex items-center justify-center bg-white">
    <div class="bg-red-600 text-white p-10 rounded-lg shadow-xl w-full max-w-lg text-center">
        <h2 class="text-3xl font-bold mb-4">Donate to Emergency Medical Aid</h2>
        <p class="mb-4">Support urgent treatments, medicine, and emergency response.</p>

        <form id="donationForm">
            <input type="number" class="w-full p-3 rounded text-black mb-3" placeholder="Donation Amount (KES)">
            <input type="text" class="w-full p-3 rounded text-black mb-3" placeholder="Phone Number 07XXXXXXXX">
            <button class="bg-white text-red-600 font-bold px-6 py-3 rounded hover:bg-gray-200 transition w-full">
                Proceed to Payment
            </button>
        </form>
    </div>
</section>

<!-- CONTACT SECTION -->
<section id="contact" class="h-screen flex items-center justify-center bg-red-50">
    <div class="text-center max-w-2xl">
        <h2 class="text-4xl font-bold text-red-600 mb-4">Contact Us</h2>
        <p class="text-lg">Email: support@helphive.org</p>
    </div>
</section>

@endsection
