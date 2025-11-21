<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Campaign;
use App\Models\Donation;
use App\Models\User;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Fetch statistics for the dashboard
        $totalUsers = User::count();
        $totalDonations = Donation::sum('amount');
        $totalCampaigns = Campaign::count();
        $recentDonations = Donation::with(['user', 'campaign'])->latest()->take(5)->get();

        // Return the dashboard view with the fetched data
        return view('admin.dashboard', compact(
            'totalUsers', 'totalDonations', 'totalCampaigns', 'recentDonations'
        ));
    }
}
