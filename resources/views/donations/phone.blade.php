@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto bg-white shadow-lg rounded-lg p-6 mt-10 text-center">
    <h2 class="text-2xl font-bold mb-4 text-red-600">Enter Your Phone Number</h2>

    <form action="{{ route('mpesa.donate') }}" method="POST">
        @csrf

        <label class="block text-left mb-2 font-semibold">Safaricom M-Pesa Number</label>
        <input type="text" name="phone"
               class="w-full border rounded p-2 mb-4"
               placeholder="e.g. 0712345678" required>

        <button type="submit"
            class="bg-red-600 text-white px-6 py-3 rounded-full hover:bg-red-700 transition w-full">
            Proceed to Pay
        </button>
    </form>
</div>
@endsection
