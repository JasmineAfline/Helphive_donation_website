@extends('layouts.app')

@section('content')
<h2 class="text-3xl font-bold mb-6">HelpHive Campaigns</h2>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">


@foreach($campaigns as $campaign)
<div class="bg-white p-4 rounded shadow-md mb-4">
    <h2 class="text-xl font-bold">{{ $campaign->title }}</h2>
    <p>{{ $campaign->description }}</p>
    <p>Goal: ${{ number_format($campaign->goal_amount) }}</p>
    <p>Raised: ${{ number_format($campaign->current_amount) }}</p>

    <!-- Campaign-specific donation link -->
    <a href="{{ route('donate.campaign', $campaign->id) }}"
       class="mt-4 inline-block bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
       Donate
    </a>
</div>
@endforeach


<!-- @foreach($campaigns as $campaign)
    <div class="bg-white shadow rounded-lg p-5">
        <h3 class="text-xl font-semibold">{{ $campaign->title }}</h3>
        <p class="text-gray-600 mb-3">{{ $campaign->description }}</p>

        <p><strong>Goal:</strong> ${{ number_format($campaign->goal_amount) }}</p>
        <p><strong>Raised:</strong> ${{ number_format($campaign->current_amount) }}</p>

        <a href="/campaigns/{{ $campaign->id }}"
           class="mt-3 inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
           View
        </a>
    </div>
@endforeach -->

</div>
@endsection
