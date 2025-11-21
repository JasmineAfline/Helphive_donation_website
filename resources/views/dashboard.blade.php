@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="flex flex-col md:flex-row gap-6">

    <!-- Sidebar -->
    <aside class="w-full md:w-1/4 bg-white p-6 rounded-lg shadow">
        <h2 class="text-xl font-bold mb-4">My Dashboard</h2>
        <ul class="space-y-2">
            <li><a href="{{ route('dashboard') }}" class="text-red-600 hover:text-red-700">Overview</a></li>
            <li><a href="{{ route('campaigns.index') }}" class="text-red-600 hover:text-red-700">Campaigns</a></li>
            <li><a href="{{ route('profile.edit') }}" class="text-red-600 hover:text-red-700">Profile</a></li>
            <li><a href="{{ route('donate.general') }}" class="text-red-600 hover:text-red-700">Donate</a></li>
        </ul>
    </aside>

    <!-- Main content -->
    <main class="flex-1 space-y-6">

        <!-- Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-gray-500 font-medium">Total Donations</h3>
                <p class="text-2xl font-bold">${{ $totalDonations ?? 0 }}</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-gray-500 font-medium">Total Campaigns</h3>
                <p class="text-2xl font-bold">{{ $totalCampaigns ?? 0 }}</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-gray-500 font-medium">My Donations</h3>
                <p class="text-2xl font-bold">{{ $myDonations->count() }}</p>
            </div>
        </div>

        <!-- Recent Donations -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-xl font-bold mb-4">Recent Donations</h3>
            @if($myDonations->isEmpty())
                <p>No donations yet.</p>
            @else
                <ul class="space-y-2">
                    @foreach($myDonations as $donation)
                        <li>
                            <span class="font-medium">{{ $donation->campaign->title ?? 'Unknown Campaign' }}</span> 
                            - ${{ $donation->amount }} 
                            <span class="text-gray-500 text-sm">({{ $donation->created_at->format('d M Y') }})</span>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>

    </main>

</div>
@endsection
