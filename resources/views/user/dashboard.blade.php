@extends('layouts.app')

@section('title', 'Your Dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 md:py-12">

    {{-- Header Section --}}
    <header class="mb-10 pb-4 border-b border-gray-100">
        <h1 class="text-4xl font-extrabold text-gray-800">
            Donor Dashboard
        </h1>
        <p class="mt-1 text-2xl font-semibold text-red-600">
            Welcome, {{ $user->name }}!
        </p>
    </header>

    {{-- Key Metrics Cards (Styled with Gradients and Icons) --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">

        {{-- 1. Total Donations Card (Red Theme) --}}
        <div class="p-6 rounded-xl shadow-xl overflow-hidden text-white 
                    bg-gradient-to-br from-red-600 to-red-400">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-medium opacity-80 uppercase tracking-wider">Total Impact Given</h3>
                    {{-- Assuming $totalDonations is formatted as a string already, if not, use number_format --}}
                    <p class="text-4xl font-extrabold mt-1">${{ $totalDonations }}</p>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
            </div>
        </div>

        {{-- 2. Recent Donations Count Card (Blue/Indigo Theme) --}}
        <div class="p-6 rounded-xl shadow-xl overflow-hidden text-white 
                    bg-gradient-to-br from-indigo-600 to-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-medium opacity-80 uppercase tracking-wider">Donations Recorded</h3>
                    <p class="text-4xl font-extrabold mt-1">{{ $recentDonations->count() }}</p>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" /></svg>
            </div>
        </div>

        {{-- 3. Total Campaigns Card (Green/Teal Theme) --}}
        <div class="p-6 rounded-xl shadow-xl overflow-hidden text-white 
                    bg-gradient-to-br from-green-600 to-teal-500">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-medium opacity-80 uppercase tracking-wider">Campaigns Supported</h3>
                    <p class="text-4xl font-extrabold mt-1">{{ $totalCampaigns }}</p>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
            </div>
        </div>
    </div>

    {{-- Recent Donations Table --}}
    <div class="bg-white p-6 rounded-xl shadow-xl">
        <h2 class="text-2xl font-bold mb-6 text-gray-800 border-b pb-3">Your Recent Donations</h2>
        
        @if($recentDonations->isEmpty())
            <div class="text-center py-10 bg-gray-50 rounded-lg border border-dashed border-gray-300">
                <p class="text-gray-600 font-medium text-lg">No donation history available.</p>
                <p class="text-gray-500 mt-2">Find a new campaign to start making an impact!</p>
                <a href="{{ route('campaigns.index') }}" class="mt-4 inline-block px-6 py-2 bg-red-600 text-white font-semibold rounded-full hover:bg-red-700 transition shadow-md">
                    Explore Campaigns &rarr;
                </a>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full text-left border-collapse">
                    <thead>
                        <tr class="text-sm font-semibold uppercase text-gray-600 bg-gray-50">
                            <th class="p-4 border-y border-gray-200 rounded-tl-lg">Campaign</th>
                            <th class="p-4 border-y border-gray-200 text-right">Amount</th>
                            <th class="p-4 border-y border-gray-200 rounded-tr-lg">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentDonations as $donation)
                            <tr class="hover:bg-gray-50 transition duration-150">
                                <td class="p-4 border-b border-gray-100 font-medium text-gray-800">
                                    {{ $donation->campaign->title ?? 'General Donation' }}
                                </td>
                                <td class="p-4 border-b border-gray-100 text-right font-extrabold text-lg text-green-600">
                                    ${{ number_format($donation->amount, 2) }}
                                </td>
                                <td class="p-4 border-b border-gray-100 text-sm text-gray-500">
                                    {{ $donation->created_at->format('d M, Y') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection