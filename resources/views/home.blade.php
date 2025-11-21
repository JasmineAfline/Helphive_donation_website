@extends('layouts.app')

@section('title', 'Home')

@section('content')
<div class="max-w-7xl mx-auto px-6">

    <!-- Hero -->
    <div class="bg-white rounded-2xl shadow-lg p-10 text-center mb-12 border border-red-200">
        <h1 class="text-4xl font-bold text-red-600 mb-4">Join HelpHive in Making a Difference</h1>
        <p class="text-2xl font-semibold text-gray-700 mb-12">
            Donate, volunteer, and spread hope to communities in need.
        </p>
        <a href="{{ route('donate.general') }}"
           class="bg-red-600 text-white px-6 py-3 rounded-full hover:bg-red-700 transition font-semibold">
           Donate Now
        </a>
    </div>

    <!-- Campaigns Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($campaigns as $campaign)
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-red-200 flex flex-col justify-between">
                <h2 class="text-xl font-semibold text-red-600 mb-2">{{ $campaign->title }}</h2>

                <p class="text-gray-700 mb-4">{{ Str::limit($campaign->description, 120) }}</p>

                <!-- FIXED goal field -->
                <p class="text-sm text-gray-500 mb-1">Goal: ${{ number_format($campaign->goal_amount) }}</p>
                <p class="text-sm text-gray-500 mb-4">Raised: ${{ number_format($campaign->current_amount) }}</p>

                <a href="{{ route('donate.campaign', $campaign->id) }}"
                   class="mt-auto bg-red-600 text-white px-4 py-2 rounded-full hover:bg-red-700 transition text-center font-medium">
                   Donate
                </a>
            </div>
        @endforeach
    </div>

</div>
@endsection
