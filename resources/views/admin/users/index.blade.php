@extends('layouts.app')

@section('title', 'Manage Users')

@section('content')
<div class="flex flex-col md:flex-row gap-6">

    <!-- Sidebar -->
    <aside class="w-full md:w-1/4 bg-white p-6 rounded-lg shadow">
        <h2 class="text-xl font-bold mb-4">Admin Dashboard</h2>
        <ul class="space-y-2">
            <li><a href="{{ route('admin.dashboard') }}" class="text-red-600 hover:text-red-700">Overview</a></li>
            <li><a href="{{ route('admin.campaigns.index') }}" class="text-red-600 hover:text-red-700">Manage Campaigns</a></li>
            <li><a href="{{ route('admin.users.index') }}" class="text-red-600 hover:text-red-700">Manage Users</a></li>
            <li><a href="{{ route('admin.reports') }}" class="text-red-600 hover:text-red-700">Reports</a></li>
            <li><a href="{{ route('profile.edit') }}" class="text-red-600 hover:text-red-700">Profile</a></li>
        </ul>
    </aside>

    <!-- Main content -->
    <main class="flex-1 space-y-6">
        <h2 class="text-2xl font-bold mb-4">Users</h2>

        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white p-6 rounded-lg shadow overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr>
                        <th class="border-b p-2">Name</th>
                        <th class="border-b p-2">Email</th>
                        <th class="border-b p-2">Role</th>
                        <th class="border-b p-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td class="border-b p-2">{{ $user->name }}</td>
                            <td class="border-b p-2">{{ $user->email }}</td>
                            <td class="border-b p-2">{{ $user->role }}</td>
                            <td class="border-b p-2 flex gap-2">
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">Edit</a>
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    @if($users->isEmpty())
                        <tr>
                            <td colspan="4" class="text-center p-4">No users found.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </main>
</div>
@endsection
