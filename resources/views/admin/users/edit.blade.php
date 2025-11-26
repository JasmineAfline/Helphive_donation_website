@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow">
    <h2 class="text-2xl font-bold mb-4">Edit User</h2>

    @if($errors->any())
        <div class="bg-red-100 text-red-800 p-3 rounded mb-4">
            <ul>
                @foreach($errors->all() as $error)
                    <li>- {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block mb-1 font-medium">Name</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full border rounded p-2">
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-medium">Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full border rounded p-2">
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-medium">Role</label>
            <select name="role" class="w-full border rounded p-2">
                <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>User</option>
                <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="employee" {{ old('role', $user->role) == 'employee' ? 'selected' : '' }}>Employee</option>
            </select>
        </div>

        <button type="submit" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">Update User</button>
    </form>
</div>
@endsection
