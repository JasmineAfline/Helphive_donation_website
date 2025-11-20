@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto mt-10 p-6 bg-white rounded-lg shadow-md">
    <h1 class="text-3xl font-bold mb-6 text-center">Admin Dashboard</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
        <div class="p-4 bg-blue-100 rounded shadow">
            <h2 class="text-xl font-semibold">Total Campaigns</h2>
            <p class="text-2xl font-bold">{{ $totalCampaigns }}</p>
        </div>
        <div class="p-4 bg-green-100 rounded shadow">
            <h2 class="text-xl font-semibold">Total Donations</h2>
            <p class="text-2xl font-bold">${{ number_format($totalDonations, 2) }}</p>
        </div>
    </div>

    <h2 class="text-2xl font-bold mb-4">All Campaigns</h2>
    <table class="min-w-full border border-gray-200 rounded">
        <thead>
            <tr class="bg-gray-100 text-left">
                <th class="px-4 py-2 border">ID</th>
                <th class="px-4 py-2 border">Title</th>
                <th class="px-4 py-2 border">Goal Amount</th>
                <th class="px-4 py-2 border">Raised</th>
                <th class="px-4 py-2 border">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($campaigns as $campaign)
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-2 border">{{ $campaign->id }}</td>
                <td class="px-4 py-2 border">{{ $campaign->title }}</td>
                <td class="px-4 py-2 border">${{ number_format($campaign->goal_amount, 2) }}</td>
                <td class="px-4 py-2 border">${{ number_format($campaign->current_amount, 2) }}</td>
                <td class="px-4 py-2 border">
                    <a href="{{ route('campaigns.show', $campaign->id) }}" class="text-blue-600 hover:underline mr-2">View</a>
                    <a href="#" class="text-red-600 hover:underline">Delete</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
