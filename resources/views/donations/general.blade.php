@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto p-6 mt-10">

    <!-- Page Title -->
    <h1 class="text-4xl font-bold text-red-600 mb-8 text-center">Make a Donation</h1>

    <form action="{{ route('donate.submit') }}" method="POST" class="space-y-8">
        @csrf

        <!-- Step 1: My Donation -->
        <div class="bg-white shadow-lg rounded-2xl p-6 border border-red-200">
            <h2 class="text-2xl font-semibold mb-4 text-red-600">1. My Donation</h2>

            <label class="block mb-2 font-medium">Earmarked for *</label>
            <select name="campaign_id" required class="w-full p-3 border border-red-300 rounded-xl mb-4 focus:ring-2 focus:ring-red-400">
                @foreach($campaigns as $campaign)
                    <option value="{{ $campaign->id }}">{{ $campaign->title }}</option>
                @endforeach
            </select>

            <label class="block mb-2 font-medium">Amount (CHF) *</label>
            <div class="flex flex-wrap gap-3 mb-4">
                <button type="button" onclick="document.querySelector('[name=amount]').value=50" class="bg-red-600 text-white px-5 py-2 rounded-full hover:bg-red-700 transition">50</button>
                <button type="button" onclick="document.querySelector('[name=amount]').value=100" class="bg-red-600 text-white px-5 py-2 rounded-full hover:bg-red-700 transition">100</button>
                <button type="button" onclick="document.querySelector('[name=amount]').value=200" class="bg-red-600 text-white px-5 py-2 rounded-full hover:bg-red-700 transition">200</button>
                <input type="number" name="amount" placeholder="Other amount" class="border border-red-300 rounded-xl px-4 py-2 flex-1 focus:ring-2 focus:ring-red-400">
            </div>

            <label class="inline-flex items-center mb-2">
                <input type="checkbox" class="form-checkbox text-red-600" name="cover_fee">
                <span class="ml-2 text-gray-700 text-sm">Cover processing fees (2%)</span>
            </label>
        </div>

        <!-- Step 2: Contact Info -->
        <div class="bg-white shadow-lg rounded-2xl p-6 border border-red-200">
            <h2 class="text-2xl font-semibold mb-4 text-red-600">2. My Contact</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <input type="text" name="first_name" placeholder="First Name *" class="w-full p-3 border border-red-300 rounded-xl focus:ring-2 focus:ring-red-400" required>
                <input type="text" name="last_name" placeholder="Last Name *" class="w-full p-3 border border-red-300 rounded-xl focus:ring-2 focus:ring-red-400" required>
            </div>
            <input type="email" name="email" placeholder="Email *" class="w-full p-3 border border-red-300 rounded-xl mt-4 focus:ring-2 focus:ring-red-400" required>
            <input type="text" name="address" placeholder="Address" class="w-full p-3 border border-red-300 rounded-xl mt-4 focus:ring-2 focus:ring-red-400">
        </div>

        <!-- Step 3: Payment -->
        <div class="bg-white shadow-lg rounded-2xl p-6 border border-red-200">
            <h2 class="text-2xl font-semibold mb-4 text-red-600">3. My Payment</h2>
            <select name="payment_method" class="w-full p-3 border border-red-300 rounded-xl focus:ring-2 focus:ring-red-400" required>
                <option value="credit_card">Credit Card</option>
                <option value="paypal">PayPal</option>
                <option value="mobile_money">Mobile Money</option>
            </select>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="w-full bg-red-600 text-white px-6 py-4 rounded-2xl hover:bg-red-700 transition text-xl font-semibold">
            Donate Now
        </button>
    </form>
</div>
@endsection
