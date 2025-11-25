@extends('layouts.app')

@section('content')
<div class="w-full min-h-screen flex items-center justify-center bg-red-600">
    <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-xl p-12 text-center">
        
        <span class="text-xs font-semibold text-red-600 bg-red-100 px-3 py-1 rounded-full uppercase">News</span>

        <h1 class="text-5xl font-bold text-gray-900 mt-4">
           Help Hive
        </h1>

        <p class="text-lg text-gray-600 mt-4">
            Emergency food, medical aid, and crisis relief efforts are underway.
        </p>

        <a href="{{ route('donate.page') }}"
           class="mt-8 inline-block bg-red-600 text-white text-lg px-8 py-3 rounded-full hover:bg-red-700 transition">
            Donate Now
        </a>
    </div>
</div>
@endsection

@section('footer')
    @include('partials.footer')
@endsection
