@extends('layouts.app')

@section('content')
<div class="bg-white p-6 shadow rounded">
    <h1 class="text-3xl font-bold mb-4">{{ $campaign->title }}</h1>

    <p class="text-gray-700 mb-6">{{ $campaign->description }}</p>

    <p><strong>Goal:</strong> ${{ number_format($campaign->goal_amount) }}</p>
    <p><strong>Raised:</strong> ${{ number_format($campaign->current_amount) }}</p>

    <a href="{{ route('donate', $campaign->id) }}" class="mt-4 inline-block bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
    Donate
    </a>

    </a>
</div>
@endsection
