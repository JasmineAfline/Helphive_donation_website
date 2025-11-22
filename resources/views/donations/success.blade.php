@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-6 bg-white shadow-md rounded-md text-center">
    <h1 class="text-2xl font-bold mb-4">Thank you!</h1>
    <p>Your donation was successfully initiated. Please check your phone to complete the payment.</p>
    <a href="{{ route('home') }}" class="mt-4 inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Back to Home</a>
</div>
@endsection
