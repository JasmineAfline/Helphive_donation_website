<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Donation;
use App\Models\Campaign;

class UserController extends Controller
{
    // Dashboard
    public function dashboard()
    {
        $user = Auth::user();

        // Total donations by user
        $totalDonations = Donation::where('user_id', $user->id)->sum('amount');

        // Total campaigns (all campaigns)
        $totalCampaigns = Campaign::count();

        // All donations by this user
        $myDonations = Donation::where('user_id', $user->id)
            ->with('campaign')
            ->latest()
            ->get();

        return view('dashboard', compact('user', 'totalDonations', 'totalCampaigns', 'myDonations'));
    }

    // You can add profile edit/update methods here
    public function editProfile()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

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
