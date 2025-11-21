<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisteredUserController extends Controller
{
    // Show registration form
    public function create()
    {
        return view('auth.register'); // Return the registration view
    }

    // Handle registration
    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:6',
        ]);

        // Create the user
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password), // Hash the password
        ]);

        // Log the user in
        Auth::login($user);

        // Redirect to home with success message
        return redirect()->route('home')->with('success', 'Registration successful!');
    }
}
