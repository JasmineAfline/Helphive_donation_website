@extends('layouts.app')

@section('title', 'Donate to ' . $campaign->title)

@section('content')
<div class="bg-gray-100 py-12 min-h-screen">
    <div class="max-w-xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Donation Card Container --}}
        <div class="bg-white p-8 md:p-10 rounded-xl shadow-2xl border-t-4 border-red-600">

            {{-- Header --}}
            <h1 class="text-3xl font-extrabold text-gray-900 mb-2">
                Donate to <span class="text-red-600">{{ $campaign->title }}</span>
            </h1>
            <p class="text-gray-600 mb-8 border-b pb-4">
                Your support directly funds this vital campaign. Thank you for your generosity.
            </p>

            {{-- M-Pesa Payment Form --}}
            <form id="mpesaPaymentForm" class="space-y-6">
                @csrf

                <input type="hidden" id="campaign_id" value="{{ $campaign->id }}">

                {{-- Amount Input --}}
                <div>
                    <label for="amount" class="block text-sm font-medium text-gray-700 mb-1">
                        Donation Amount (KES)
                    </label>
                    <input 
                        type="number" 
                        id="amount" 
                        placeholder="e.g., 500"
                        min="1"
                        required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-red-500 focus:border-red-500 text-lg transition duration-150"
                    >
                </div>

                {{-- Phone Input --}}
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">
                        Phone Number (Safaricom M-Pesa)
                    </label>
                    <input 
                        type="text" 
                        id="phone" 
                        placeholder="07xxxxxxxx" 
                        required
                        pattern="07[0-9]{8}"
                        title="Phone number must be in the format 07xxxxxxxx (10 digits)"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-red-500 focus:border-red-500 text-lg transition duration-150"
                    >
                    <p class="mt-2 text-xs text-gray-500">A payment prompt will be sent to this number.</p>
                </div>
                
                {{-- Payment Button --}}
                <button 
                    type="button" 
                    id="payBtn" 
                    class="w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-lg 
                           shadow-md text-lg font-bold text-white bg-green-600 
                           hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 
                           transition duration-150 transform hover:scale-[1.01]"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                    Confirm Donation via M-Pesa
                </button>
            </form>

        </div>
        
        {{-- Security Message --}}
        <div class="mt-6 text-center text-sm text-gray-500">
            Secure payment powered by Safaricom M-Pesa. Your personal data is protected.
        </div>

    </div>
</div>

<script>
document.getElementById('payBtn').addEventListener('click', function () {
    const payBtn = this;
    const form = document.getElementById('mpesaPaymentForm');
    
    if (!form.reportValidity()) {
        return; // Stop if form validation fails
    }

    // Disable button and show loading state
    payBtn.disabled = true;
    payBtn.innerHTML = '<svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Sending Request...';


    fetch("{{ route('mpesa.donate') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({
            campaign_id: document.getElementById('campaign_id').value,
            amount: document.getElementById('amount').value,
            phone: document.getElementById('phone').value
        })
    })
    .then(res => res.json())
    .then(data => {
        console.log("Response:", data);
        if (data.success) {
             alert("Success! Check your phone now for the M-Pesa prompt to complete the payment.");
        } else {
             alert("Payment request failed: " + (data.message || "Please check your phone number and try again."));
        }
    })
    .catch(error => {
        console.error('Fetch error:', error);
        alert("An unexpected error occurred. Please try again.");
    })
    .finally(() => {
        // Re-enable button
        payBtn.disabled = false;
        payBtn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" /></svg>Confirm Donation via M-Pesa';
    });
});
</script>

@endsection