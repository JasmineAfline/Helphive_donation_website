@extends('layouts.app')

@section('title', 'Your Dashboard')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

    {{-- Welcome Header --}}
    <header class="mb-8">
        <h1 class="text-4xl font-extrabold text-gray-800">Welcome back, <span class="text-red-600">{{ $user->name }}</span> 👋</h1>
        <p class="mt-2 text-gray-600 text-lg">Your hub for tracking impact and managing your details.</p>
    </header>

    {{-- Stats Overview Card --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        {{-- Calculate total donations and count --}}
        @php
            $totalDonated = $donations->sum('amount');
            $donationCount = $donations->count();
        @endphp

        {{-- Total Donations Card (Red/Pink Gradient) --}}
        <div class="relative p-6 rounded-xl shadow-lg overflow-hidden
                    bg-gradient-to-br from-red-600 to-pink-500 text-white">
            <div class="absolute inset-0 opacity-10">
                {{-- Decorative SVG pattern --}}
                <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                    <circle cx="0" cy="0" r="20" fill="currentColor" />
                    <circle cx="100" cy="100" r="20" fill="currentColor" />
                    <circle cx="50" cy="50" r="15" fill="currentColor" />
                </svg>
            </div>
            <div class="relative z-10 flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-white/80">Total Amount Donated</p>
                    <p class="text-3xl font-bold mt-1">KES {{ number_format($totalDonated) }}</p>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-white/70" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
            </div>
        </div>

        {{-- Donation Count Card (Indigo/Blue Gradient) --}}
        <div class="relative p-6 rounded-xl shadow-lg overflow-hidden
                    bg-gradient-to-br from-indigo-600 to-blue-500 text-white">
            <div class="absolute inset-0 opacity-10">
                <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                    <rect x="0" y="0" width="30" height="30" fill="currentColor" />
                    <rect x="70" y="70" width="30" height="30" fill="currentColor" />
                </svg>
            </div>
            <div class="relative z-10 flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-white/80">Total Donations Made</p>
                    <p class="text-3xl font-bold mt-1">{{ number_format($donationCount) }}</p>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-white/70" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 12.79A9 9 0 1111.21 3a7 7 0 009.79 9.79v0z" /></svg>
            </div>
        </div>

        {{-- Campaign Link Card (Green/Teal Gradient) --}}
        <a href="{{ route('campaigns.index') }}" class="relative p-6 rounded-xl shadow-lg overflow-hidden
                    bg-gradient-to-br from-green-600 to-teal-500 text-white
                    hover:from-green-700 hover:to-teal-600 transition-all duration-300 group">
            <div class="absolute inset-0 opacity-10">
                <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                    <polygon points="0,0 100,0 50,100" fill="currentColor" />
                </svg>
            </div>
            <div class="relative z-10 flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-white/80">Support Another Cause</p>
                    <p class="text-xl font-bold mt-1">Make a New Donation</p>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-white group-hover:translate-x-1 transition duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
            </div>
        </a>
    </div>

    <div class="bg-white p-8 rounded-2xl shadow-xl">
        <h3 class="text-2xl font-bold mb-6 text-gray-800 border-b pb-3">Your Donation History</h3>

        @if ($donations->isEmpty())
            <div class="text-center py-10 bg-gray-50 rounded-lg border border-dashed border-gray-300">
                <p class="text-gray-600 font-medium text-lg">Looks like this is your first time here!</p>
                <p class="text-gray-500 mt-2">No donations recorded yet. Start making an impact today!</p>
                <a href="{{ route('campaigns.index') }}" class="mt-4 inline-block px-4 py-2 bg-red-600 text-white font-semibold rounded-full hover:bg-red-700 transition shadow">
                    Find a Campaign
                </a>
            </div>
        @else
            {{-- Donation List Table/Cards --}}
            <div class="overflow-x-auto">
                <ul class="space-y-4">
                    @foreach ($donations as $donation)
                        <li class="bg-gray-50 p-5 rounded-xl border border-gray-100 transition duration-200 hover:shadow-md hover:bg-white">
                            <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
                                
                                {{-- Campaign Info --}}
                                <div class="flex-1 min-w-0 mb-2 md:mb-0">
                                    <p class="text-xs font-semibold uppercase text-red-600">Campaign</p>
                                    <p class="text-lg font-bold text-gray-800 truncate">{{ $donation->campaign->title ?? 'General Fund Donation' }}</p>
                                </div>

                                {{-- Amount --}}
                                <div class="flex-shrink-0 w-full md:w-auto md:text-right mr-6">
                                    <p class="text-xs font-semibold uppercase text-gray-500">Amount</p>
                                    <p class="text-xl font-extrabold text-green-600">KES {{ number_format($donation->amount) }}</p>
                                </div>

                                {{-- Date --}}
                                <div class="flex-shrink-0 w-full md:w-auto md:text-right">
                                    <p class="text-xs font-semibold uppercase text-gray-500">Date</p>
                                    <p class="text-sm text-gray-500 font-medium">{{ $donation->created_at->format('d M, Y \a\t H:i') }}</p>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

    {{-- Placeholder for future sections, e.g., Profile Settings --}}
    <div class="mt-10 pt-6 border-t border-gray-200 text-center">
        <a href="#" class="text-sm font-medium text-gray-600 hover:text-red-600 transition">Manage Profile Settings &rarr;</a>
    </div>

</div>
@endsection