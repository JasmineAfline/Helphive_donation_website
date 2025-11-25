@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="flex flex-col md:flex-row gap-6">

    <aside class="w-full md:w-1/4 bg-white p-6 rounded-lg shadow">
        <h2 class="text-xl font-bold mb-4">Admin Dashboard</h2>
        <ul class="space-y-2">
            <li><a href="{{ route('admin.dashboard') }}">Overview</a></li>
            <li><a href="{{ route('admin.campaigns.index') }}">Manage Campaigns</a></li>
            <li><a href="#">Reports</a></li>
        </ul>
    </aside>

    <main class="flex-1 space-y-6">

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

            <div class="bg-white p-6 rounded-lg shadow">
                <h3>Total Users</h3>
                <p>{{ $totalUsers }}</p>
            </div>

            <div class="bg-white p-6 rounded-lg shadow">
                <h3>Total Donations</h3>
                <p>${{ $totalDonations }}</p>
            </div>

            <div class="bg-white p-6 rounded-lg shadow">
                <h3>Total Campaigns</h3>
                <p>{{ $totalCampaigns }}</p>
            </div>

            <div class="bg-white p-6 rounded-lg shadow">
                <h3>Recent Donations</h3>
                <p>{{ $recentDonations->count() }}</p>
            </div>

        </div>

        <div class="bg-white p-6 rounded-lg shadow overflow-x-auto">
            <h3 class="text-xl font-bold mb-4">Recent Donations</h3>
            <table class="w-full">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Campaign</th>
                        <th>Amount</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentDonations as $donation)
                    <tr>
                        <td>{{ $donation->user->name }}</td>
                        <td>{{ $donation->campaign->title }}</td>
                        <td>${{ $donation->amount }}</td>
                        <td>{{ $donation->created_at->format('d M Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </main>

</div>
@endsection
