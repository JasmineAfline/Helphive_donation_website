@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-6 bg-white shadow-md rounded-md">
    <h1 class="text-2xl font-bold mb-2">Donate to {{ $campaign->title }}</h1>
    <p class="mb-6 text-gray-700">{{ $campaign->description }}</p>

    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('mpesa.donate') }}" method="POST">
        @csrf
        <input type="hidden" name="campaign_id" value="{{ $campaign->id }}">

        <div class="mb-4">
            <label class="block mb-1 font-medium text-gray-700">Donation Amount (KES)</label>
            <input type="number" name="amount" min="1" required
                class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-medium text-gray-700">Phone Number</label>
            <input type="text" name="phone" placeholder="07XXXXXXXX" required
                class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
        </div>

        <button type="submit"
            class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
            Proceed to Payment
        </button>
    </form>
</div>
@endsection
