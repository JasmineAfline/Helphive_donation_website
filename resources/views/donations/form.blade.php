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

    <form action="{{ route('donate.submit') }}" method="POST" class="space-y-4">
        @csrf
        <input type="hidden" name="campaign_id" value="{{ $campaign->id }}">

        <!-- Contact Info -->
        <h2 class="text-lg font-semibold mb-2">Your Information</h2>
        <div>
            <label for="first_name" class="block text-gray-700 font-medium mb-1">First Name</label>
            <input type="text" name="first_name" id="first_name" value="{{ old('first_name') }}" required
                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div>
            <label for="last_name" class="block text-gray-700 font-medium mb-1">Last Name</label>
            <input type="text" name="last_name" id="last_name" value="{{ old('last_name') }}" required
                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div>
            <label for="email" class="block text-gray-700 font-medium mb-1">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required
                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <!-- Donation Amount -->
        <div>
            <label for="amount" class="block text-gray-700 font-medium mb-1">Donation Amount (KES)</label>
            <input type="number" name="amount" id="amount" min="1" value="{{ old('amount') }}" required
                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <!-- Payment Method -->
        <h2 class="text-lg font-semibold mt-4 mb-2">Payment Method</h2>
        <div>
            <label for="payment_method" class="block text-gray-700 font-medium mb-1">Choose Payment Method</label>
            <select name="payment_method" id="payment_method" required
                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">Select Payment Method</option>
                <option value="mobile_money">Mobile Money</option>
                <option value="card">Card</option>
                <option value="paypal">PayPal</option>
            </select>
        </div>

        <!-- Mobile Money Providers -->
        <div id="mobile_money_provider_div" style="display: none;">
            <label for="mobile_money_provider" class="block text-gray-700 font-medium mb-1">Mobile Money Provider</label>
            <select name="mobile_money_provider" id="mobile_money_provider"
                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">Select Provider</option>
                <option value="mpesa">M-Pesa</option>
                <option value="airtel_money">Airtel Money</option>
            </select>
        </div>

        <button type="submit"
            class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition-colors">
            Donate Now
        </button>
    </form>
</div>

<script>
    const paymentMethod = document.getElementById('payment_method');
    const providerDiv = document.getElementById('mobile_money_provider_div');

    paymentMethod.addEventListener('change', function() {
        if (this.value === 'mobile_money') {
            providerDiv.style.display = 'block';
        } else {
            providerDiv.style.display = 'none';
            document.getElementById('mobile_money_provider').value = '';
        }
    });
</script>
@endsection
