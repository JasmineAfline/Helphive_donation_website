<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Campaign;
use App\Models\Donation;

class AdminController extends Controller
{
    // Admin dashboard
    public function dashboard()
    {
        $totalCampaigns = Campaign::count();
        $totalDonations = Donation::sum('amount');
        $campaigns = Campaign::all();

        return view('admin.dashboard', compact('totalCampaigns', 'totalDonations', 'campaigns'));
    }
}
