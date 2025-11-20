@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-6 bg-white shadow-md rounded-md">
    <h1 class="text-2xl font-bold mb-4">Donate to {{ $campaign->title }}</h1>
    <p class="mb-6 text-gray-700">{{ $campaign->description }}</p>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('donate') }}" method="POST" class="space-y-4">
        @csrf
        <input type="hidden" name="campaign_id" value="{{ $campaign->id }}">

        <div>
            <label for="name" class="block text-gray-700 font-medium mb-1">Name</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" required
                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div>
            <label for="email" class="block text-gray-700 font-medium mb-1">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required
                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div>
            <label for="amount" class="block text-gray-700 font-medium mb-1">Donation Amount (USD)</label>
            <input type="number" name="amount" id="amount" min="1" value="{{ old('amount') }}" required
                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <button type="submit"
            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition-colors">
            Donate Now
        </button>
    </form>
</div>
@endsection
