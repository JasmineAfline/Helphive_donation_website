@extends('layouts.app')

@section('title', 'Manage Campaigns')

@section('content')
<div class="flex flex-col md:flex-row gap-6">

    <!-- Sidebar -->
    <aside class="w-full md:w-1/4 bg-white p-6 rounded-lg shadow">
        <h2 class="text-xl font-bold mb-4">Admin Dashboard</h2>
        <ul class="space-y-2">
            <li><a href="{{ route('admin.dashboard') }}" class="text-red-600 hover:text-red-700">Overview</a></li>
            <li><a href="{{ route('admin.campaigns.index') }}" class="text-red-600 hover:text-red-700 font-bold">Manage Campaigns</a></li>
            <li><a href="{{ route('admin.users.index') }}" class="text-red-600 hover:text-red-700">Manage Users</a></li>
            <li><a href="{{ route('admin.reports') }}" class="text-red-600 hover:text-red-700">Reports</a></li>
        </ul>
    </aside>

    <!-- Main content -->
    <main class="flex-1 space-y-6">

        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-bold">Campaigns</h2>
            <a href="{{ route('admin.campaigns.create') }}" 
               class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
               Add Campaign
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white p-6 rounded-lg shadow overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr>
                        <th class="border-b p-2">Title</th>
                        <th class="border-b p-2">Goal Amount</th>
                        <th class="border-b p-2">Current Amount</th>
                        <th class="border-b p-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($campaigns as $campaign)
                        <tr>
                            <td class="border-b p-2">{{ $campaign->title }}</td>
                            <td class="border-b p-2">${{ $campaign->goal_amount }}</td>
                            <td class="border-b p-2">${{ $campaign->current_amount }}</td>
                            <td class="border-b p-2 space-x-2">
                                <a href="{{ route('admin.campaigns.edit', $campaign->id) }}" 
                                   class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">
                                   Edit
                                </a>
                                <form action="{{ route('admin.campaigns.destroy', $campaign->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600"
                                            onclick="return confirm('Are you sure you want to delete this campaign?');">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-2 text-center">No campaigns found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </main>

</div>
@endsection
