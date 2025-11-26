<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Campaign;
use App\Models\User;
use App\Models\Donation;

class AdminController extends Controller
{
    // Admin Dashboard
    public function dashboard()
    {
        $totalUsers = User::count();
        $totalDonations = Donation::sum('amount');
        $totalCampaigns = Campaign::count();
        $recentDonations = Donation::with(['user','campaign'])->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalUsers', 'totalDonations', 'totalCampaigns', 'recentDonations'
        ));
    }

    // Campaigns Management
    public function index()
    {
        $campaigns = Campaign::latest()->get();
        return view('admin.campaigns.index', compact('campaigns'));
    }

    public function create()
    {
        return view('admin.campaigns.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'goal_amount' => 'required|numeric|min:0',
        ]);

        Campaign::create([
            'title' => $request->title,
            'description' => $request->description,
            'goal_amount' => $request->goal_amount,
            'current_amount' => 0,
        ]);

        return redirect()->route('admin.campaigns.index')->with('success','Campaign created successfully.');
    }

    public function edit($id)
    {
        $campaign = Campaign::findOrFail($id);
        return view('admin.campaigns.edit', compact('campaign'));
    }

    public function update(Request $request, $id)
    {
        $campaign = Campaign::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'goal_amount' => 'required|numeric|min:0',
        ]);

        $campaign->update([
            'title' => $request->title,
            'description' => $request->description,
            'goal_amount' => $request->goal_amount,
        ]);

        return redirect()->route('admin.campaigns.index')->with('success','Campaign updated successfully.');
    }

    public function destroy($id)
    {
        Campaign::findOrFail($id)->delete();
        return redirect()->route('admin.campaigns.index')->with('success','Campaign deleted successfully.');
    }

    // Users Management
public function usersIndex()
{
    $users = \App\Models\User::latest()->get();
    return view('admin.users.index', compact('users'));
}

public function usersEdit($id)
{
    $user = \App\Models\User::findOrFail($id);
    return view('admin.users.edit', compact('user'));
}

public function usersUpdate(Request $request, $id)
{
    $user = \App\Models\User::findOrFail($id);

    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:users,email,' . $user->id,
        'role' => 'required|in:user,admin,employee',
    ]);

    $user->update($request->only('name', 'email', 'role'));

    return redirect()->route('admin.users.index')
                     ->with('success', 'User updated successfully.');
}

public function usersDestroy($id)
{
    $user = \App\Models\User::findOrFail($id);
    $user->delete();

    return redirect()->route('admin.users.index')
                     ->with('success', 'User deleted successfully.');
}

   
    // Reports
    public function reports()
    {
        $donations = Donation::with(['user','campaign'])->latest()->get();
        $summary = [
            'total_donations' => $donations->sum('amount'),
            'total_transactions' => $donations->count(),
            'top_campaigns' => Campaign::withSum('donations','amount')
                                ->orderBy('donations_sum_amount','DESC')->take(5)->get(),
        ];
        return view('admin.reports', compact('donations','summary'));
    }
}
