<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Donation;
use App\Models\Campaign;

class UserController extends Controller
{
    // Dashboard
    public function dashboard()
    {
        $user = Auth::user();

        // Total users in the system (for admin dashboard)
        $totalUsers = User::count();

        // Total donations by this user
        $totalDonations = Donation::where('user_id', $user->id)->sum('amount');

        // Total campaigns in the system
        $totalCampaigns = Campaign::count();

        // Recent donations by this user
        $recentDonations = Donation::where('user_id', $user->id)
            ->with('campaign')  // eager load related campaign
            ->latest()
            ->get();

        return view('dashboard', compact(
            'user',
            'totalUsers',
            'totalDonations',
            'totalCampaigns',
            'recentDonations'
        ));
    }

    // Edit Profile
    public function editProfile()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    // Update Profile
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
        ]);

        $user->update($request->only('name', 'email'));

        return redirect()->route('profile.edit')->with('success', 'Profile updated successfully.');
    }
}
