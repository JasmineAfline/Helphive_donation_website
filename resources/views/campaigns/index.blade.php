@extends('layouts.app')

@section('content')
<h2 class="text-3xl font-bold mb-6 text-red-600">HelpHive Campaigns</h2>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

@foreach($campaigns as $campaign)
<div class="bg-white p-6 rounded-2xl shadow-lg border border-red-200">
    <h2 class="text-xl font-bold text-red-600 mb-2">{{ $campaign->title }}</h2>

    <p class="text-gray-700 mb-3">{{ $campaign->description }}</p>

    <p class="text-sm text-gray-500"><strong>Goal:</strong> ${{ number_format($campaign->goal_amount, 2) }}</p>
    <p class="text-sm text-gray-500 mb-4"><strong>Raised:</strong> ${{ number_format($campaign->current_amount, 2) }}</p>

    <a href="{{ route('donate.campaign', $campaign->id) }}"
       class="mt-4 inline-block bg-red-600 text-white px-4 py-2 rounded-full hover:bg-red-700 transition">
       Donate
    </a>
</div>

@endforeach

</div>
@endsection
