@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="flex flex-col md:flex-row gap-6">

    <!-- Sidebar -->
    <aside class="w-full md:w-1/4 bg-white p-6 rounded-lg shadow">
        <h2 class="text-xl font-bold mb-4">Admin Dashboard</h2>
        <ul class="space-y-2">
            <li><a href="{{ route('admin.dashboard') }}" class="text-red-600 hover:text-red-700">Overview</a></li>
            <li><a href="{{ route('admin.campaigns.index') }}" class="text-red-600 hover:text-red-700">Manage Campaigns</a></li>
            <li><a href="{{ route('admin.reports') }}" class="text-red-600 hover:text-red-700">Reports</a></li>
            <li><a href="{{ route('profile.edit') }}" class="text-red-600 hover:text-red-700">Profile</a></li>
        </ul>
    </aside>

    <!-- Main content -->
    <main class="flex-1 space-y-6">

        <!-- Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-gray-500 font-medium">Total Users</h3>
                <p class="text-2xl font-bold">{{ $totalUsers }}</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-gray-500 font-medium">Total Donations</h3>
                <p class="text-2xl font-bold">${{ $totalDonations }}</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-gray-500 font-medium">Total Campaigns</h3>
                <p class="text-2xl font-bold">{{ $totalCampaigns }}</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-gray-500 font-medium">Recent Donations</h3>
                <p class="text-2xl font-bold">{{ $recentDonations->count() }}</p>
            </div>
        </div>

        <!-- Recent Donations Table -->
        <div class="bg-white p-6 rounded-lg shadow overflow-x-auto">
            <h3 class="text-xl font-bold mb-4">Recent Donations</h3>
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr>
                        <th class="border-b p-2">User</th>
                        <th class="border-b p-2">Campaign</th>
                        <th class="border-b p-2">Amount</th>
                        <th class="border-b p-2">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentDonations as $donation)
                        <tr>
                            <td class="border-b p-2">{{ $donation->user->name }}</td>
                            <td class="border-b p-2">{{ $donation->campaign->title }}</td>
                            <td class="border-b p-2">${{ $donation->amount }}</td>
                            <td class="border-b p-2">{{ $donation->created_at->format('d M Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </main>
</div>
@endsection
