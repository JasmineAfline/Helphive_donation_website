<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Campaign;

class AdminController extends Controller
{
    public function index()
    {
        $campaigns = Campaign::latest()->get();
        return view('admin.campaigns.index', compact('campaigns'));
    }

    public function dashboard()
    {
        $totalUsers = \App\Models\User::count();
        $totalDonations = \App\Models\Donation::sum('amount');
        $totalCampaigns = Campaign::count();
        $recentDonations = \App\Models\Donation::with(['user', 'campaign'])
                                ->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalUsers', 'totalDonations', 'totalCampaigns', 'recentDonations'
        ));
    }

    public function create()
    {
        return view('admin.campaigns.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'goal_amount' => 'required|numeric|min:0',
        ]);

        Campaign::create([
            'title' => $request->title,
            'description' => $request->description,
            'goal_amount' => $request->goal_amount,
            'current_amount' => 0,
        ]);

        return redirect()->route('admin.campaigns.index')
                ->with('success', 'Campaign created successfully.');
    }

    public function edit($id)
    {
        $campaign = Campaign::findOrFail($id);
        return view('admin.campaigns.edit', compact('campaign'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'goal_amount' => 'required|numeric|min:0',
        ]);

        $campaign = Campaign::findOrFail($id);
        $campaign->update([
            'title' => $request->title,
            'description' => $request->description,
            'goal_amount' => $request->goal_amount,
        ]);

        return redirect()->route('admin.campaigns.index')
                ->with('success', 'Campaign updated successfully.');
    }

    public function destroy($id)
    {
        Campaign::findOrFail($id)->delete();

        return redirect()->route('admin.campaigns.index')
                ->with('success', 'Campaign deleted successfully.');
    }

public function reports()
{
    $donations = \App\Models\Donation::with(['user', 'campaign'])
                    ->latest()->get();

    $summary = [
        'total_donations' => $donations->sum('amount'),
        'total_transactions' => $donations->count(),
        'top_campaigns' => \App\Models\Campaign::withSum('donations', 'amount')
                            ->orderBy('donations_sum_amount', 'DESC')
                            ->take(5)->get(),
    ];

    return view('admin.reports', compact('donations', 'summary'));
}






}
