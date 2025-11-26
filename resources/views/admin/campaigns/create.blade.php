@extends('layouts.app')

@section('title', 'Add Campaign')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow">
    <h2 class="text-2xl font-bold mb-4">Add New Campaign</h2>

    @if($errors->any())
        <div class="bg-red-100 text-red-800 p-3 rounded mb-4">
            <ul>
                @foreach($errors->all() as $error)
                    <li>- {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.campaigns.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label class="block mb-1 font-medium">Title</label>
            <input type="text" name="title" value="{{ old('title') }}" class="w-full border rounded p-2">
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-medium">Description</label>
            <textarea name="description" rows="4" class="w-full border rounded p-2">{{ old('description') }}</textarea>
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-medium">Goal Amount</label>
            <input type="number" name="goal_amount" value="{{ old('goal_amount') }}" class="w-full border rounded p-2">
        </div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Create Campaign</button>
    </form>
</div>
@endsection
