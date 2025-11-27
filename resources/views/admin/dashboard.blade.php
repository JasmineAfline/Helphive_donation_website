@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 bg-gray-50 min-h-[calc(100vh-16rem)]">

    <header class="mb-8">
        <h1 class="text-3xl font-extrabold text-gray-800 border-b pb-2">Administrator Panel</h1>
        <p class="text-gray-500 mt-1">Manage platform campaigns, users, and transactions.</p>
    </header>

    <div class="flex flex-col md:flex-row gap-8">

        <aside class="w-full md:w-64 bg-white p-6 rounded-xl shadow-lg h-fit border border-gray-100">
            <h2 class="text-xl font-bold text-gray-800 mb-5 border-b pb-3">Navigation</h2>
            <ul class="space-y-3">
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 p-3 rounded-lg font-semibold text-white bg-red-600 shadow-md hover:bg-red-700 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor"><path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/></svg>
                        Overview
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.campaigns.index') }}" class="flex items-center gap-3 p-3 rounded-lg font-medium text-gray-700 hover:bg-red-50 hover:text-red-600 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2v20M17 5H7M17 19H7M5 9h14M5 15h14"/></svg>
                        Manage Campaigns
                    </a>
                </li>
                <!-- <li>
                    <a href="{{ route('admin.reports') }}" class="flex items-center gap-3 p-3 rounded-lg font-medium text-gray-700 hover:bg-red-50 hover:text-red-600 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>
                        Reports & Analytics
                    </a>
                </li> -->
                <li>
                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 p-3 rounded-lg font-medium text-gray-700 hover:bg-red-50 hover:text-red-600 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2m8-10a4 4 0 100-8 4 4 0 000 8z"/></svg>
                        Admin Profile
                    </a>
                </li>
            </ul>
        </aside>

        <main class="flex-1 space-y-8">

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                
                {{-- 1. Total Users (Blue) --}}
                <div class="p-6 rounded-xl shadow-xl text-white bg-gradient-to-br from-blue-600 to-indigo-500">
                    <h3 class="text-sm font-medium opacity-80 uppercase tracking-wider">Total Users</h3>
                    <p class="text-3xl font-extrabold mt-1">{{ number_format($totalUsers) }}</p>
                </div>
                
                {{-- 2. Total Donations (Green/Teal) --}}
                <div class="p-6 rounded-xl shadow-xl text-white bg-gradient-to-br from-green-600 to-teal-500">
                    <h3 class="text-sm font-medium opacity-80 uppercase tracking-wider">Total Donations</h3>
                    <p class="text-3xl font-extrabold mt-1">${{ number_format($totalDonations) }}</p>
                </div>
                
                {{-- 3. Total Campaigns (Yellow/Orange) --}}
                <div class="p-6 rounded-xl shadow-xl text-white bg-gradient-to-br from-yellow-600 to-orange-500">
                    <h3 class="text-sm font-medium opacity-80 uppercase tracking-wider">Total Campaigns</h3>
                    <p class="text-3xl font-extrabold mt-1">{{ number_format($totalCampaigns) }}</p>
                </div>
                
                {{-- 4. Recent Donations Count (Red/Pink) --}}
                <div class="p-6 rounded-xl shadow-xl text-white bg-gradient-to-br from-red-600 to-pink-500">
                    <h3 class="text-sm font-medium opacity-80 uppercase tracking-wider">Recent Donations</h3>
                    <p class="text-3xl font-extrabold mt-1">{{ number_format($recentDonations->count()) }}</p>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-xl border border-gray-100 overflow-x-auto">
                <h3 class="text-2xl font-bold text-gray-800 mb-5 border-b pb-3">Latest Activity</h3>
                
                @if($recentDonations->isEmpty())
                    <p class="text-gray-500 py-4 text-center">No recent donations to display.</p>
                @else
                    <table class="min-w-full text-left border-collapse">
                        <thead>
                            <tr class="text-xs font-semibold uppercase text-gray-500 bg-gray-50">
                                <th class="p-4 rounded-tl-lg">User</th>
                                <th class="p-4">Campaign</th>
                                <th class="p-4 text-right">Amount</th>
                                <th class="p-4 rounded-tr-lg">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentDonations as $donation)
                                <tr class="hover:bg-gray-50 transition duration-150">
                                    {{-- Assuming the user relationship exists --}}
                                    <td class="p-4 border-b border-gray-100 font-medium text-gray-800">{{ $donation->user->name }}</td>
                                    {{-- Assuming the campaign relationship exists --}}
                                    <td class="p-4 border-b border-gray-100 text-sm text-gray-700">{{ $donation->campaign->title }}</td>
                                    <td class="p-4 border-b border-gray-100 text-right font-bold text-green-600">${{ number_format($donation->amount, 2) }}</td>
                                    <td class="p-4 border-b border-gray-100 text-sm text-gray-500">{{ $donation->created_at->format('d M, H:i') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>

        </main>
    </div>
</div>
@endsection