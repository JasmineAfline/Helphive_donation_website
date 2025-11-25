@extends('layouts.app')

@section('title', 'Reports')

@section('content')
<div class="space-y-6">

    <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-2xl font-bold mb-4">Donation Summary</h2>

        <p><strong>Total Donations:</strong> ${{ $summary['total_donations'] }}</p>
        <p><strong>Total Transactions:</strong> {{ $summary['total_transactions'] }}</p>
    </div>

    <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-xl font-bold mb-4">Top Campaigns</h2>

        <table class="w-full">
            <thead>
                <tr class="border-b">
                    <th class="p-3">Campaign</th>
                    <th class="p-3">Total Raised</th>
                </tr>
            </thead>
            <tbody>
                @foreach($summary['top_campaigns'] as $item)
                <tr class="border-b">
                    <td class="p-3">{{ $item->title }}</td>
                    <td class="p-3">${{ $item->donations_sum_amount ?? 0 }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>



    <div class="bg-white p-6 rounded-lg shadow overflow-x-auto">
        <h2 class="text-xl font-bold mb-4">All Donation Records</h2>

        <table class="w-full">
            <thead>
                <tr class="border-b">
                    <th class="p-3">User</th>
                    <th class="p-3">Campaign</th>
                    <th class="p-3">Amount</th>
                    <th class="p-3">Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($donations as $donation)
                <tr class="border-b">
                    <td class="p-3">{{ $donation->user->name }}</td>
                    <td class="p-3">{{ $donation->campaign->title }}</td>
                    <td class="p-3">${{ $donation->amount }}</td>
                    <td class="p-3">{{ $donation->created_at->format('d M Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
@endsection
