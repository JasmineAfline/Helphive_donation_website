@extends('layouts.app')

@section('title', 'Profile')

@section('content')
<div class="max-w-4xl mx-auto bg-white rounded-2xl shadow-lg p-8">
    <h1 class="text-3xl font-bold text-red-600 mb-6">My Profile</h1>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('profile.update') }}" method="POST" class="space-y-6">
        @csrf

        <div>
            <label class="block mb-1 font-semibold">Name</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full border border-gray-300 rounded-lg p-2">
            @error('name') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block mb-1 font-semibold">Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full border border-gray-300 rounded-lg p-2">
            @error('email') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block mb-1 font-semibold">Password</label>
            <input type="password" name="password" placeholder="Leave blank to keep current password" class="w-full border border-gray-300 rounded-lg p-2">
            @error('password') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block mb-1 font-semibold">Confirm Password</label>
            <input type="password" name="password_confirmation" class="w-full border border-gray-300 rounded-lg p-2">
        </div>

        <button type="submit" class="bg-red-600 text-white px-6 py-2 rounded-2xl hover:bg-red-700 font-semibold">Update Profile</button>
    </form>
</div>
@endsection
