@extends('layouts.app')

@section('title', 'Manage Campaigns')

@section('content')
<div class="bg-white p-6 rounded-lg shadow">

    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-bold">All Campaigns</h2>
        <a href="{{ route('admin.campaigns.create') }}"
           class="px-4 py-2 bg-red-600 text-white rounded">Create Campaign</a>
    </div>

    <table class="w-full">
        <thead>
            <tr class="border-b">
                <th class="p-3">Title</th>
                <th class="p-3">Goal</th>
                <th class="p-3">Raised</th>
                <th class="p-3">Actions</th>
            </tr>
        </thead>

        <tbody>
            @foreach($campaigns as $campaign)
            <tr class="border-b">
                <td class="p-3">{{ $campaign->title }}</td>
                <td class="p-3">${{ $campaign->goal_amount }}</td>
                <td class="p-3">${{ $campaign->current_amount }}</td>
                <td class="p-3 flex gap-3">
                    <a href="{{ route('admin.campaigns.edit', $campaign->id) }}"
                       class="text-blue-600">Edit</a>

                    <form action="{{ route('admin.campaigns.destroy', $campaign->id) }}"
                          method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                onclick="return confirm('Delete this campaign?')"
                                class="text-red-600">
                            Delete
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach

            @if($campaigns->count() === 0)
            <tr>
                <td colspan="4" class="text-center p-3">No campaigns available.</td>
            </tr>
            @endif
        </tbody>
    </table>

</div>
@endsection
