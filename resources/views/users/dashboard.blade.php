@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="max-w-4xl mx-auto bg-white p-6 rounded-2xl shadow">
    <h2 class="text-2xl font-bold mb-4 text-red-600">Welcome, {{ $user->name }}!</h2>

    <h3 class="text-xl font-semibold mb-3">Your Donations</h3>

    @if ($donations->count() == 0)
        <p class="text-gray-600">You have not made any donations yet.</p>
    @else
        <ul class="space-y-3">
            @foreach ($donations as $donation)
                <li class="p-4 border rounded-lg bg-red-50">
                    <p><strong>Campaign:</strong> {{ $donation->campaign->title }}</p>
                    <p><strong>Amount:</strong> ${{ number_format($donation->amount) }}</p>
                    <p class="text-sm text-gray-500">{{ $donation->created_at->format('M d, Y') }}</p>
                </li>
            @endforeach
        </ul>
    @endif
</div>
@endsection
