@extends('layouts.app')

@section('title', 'Edit Campaign')

@section('content')
<div class="bg-white p-6 rounded-lg shadow max-w-xl mx-auto">

    <h2 class="text-2xl font-bold mb-4">Edit Campaign</h2>

    <form action="{{ route('admin.campaigns.update', $campaign->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label class="block mb-2">Title</label>
        <input type="text" name="title" value="{{ $campaign->title }}" class="w-full p-2 border rounded mb-4">

        <label class="block mb-2">Description</label>
        <textarea name="description" rows="4" class="w-full p-2 border rounded mb-4">{{ $campaign->description }}</textarea>

        <label class="block mb-2">Goal Amount</label>
        <input type="number" name="goal_amount" value="{{ $campaign->goal_amount }}" class="w-full p-2 border rounded mb-4">

        <button class="w-full bg-red-600 text-white p-2 rounded">
            Update Campaign
        </button>
    </form>

</div>
@endsection
