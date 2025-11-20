<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Donation;
use App\Models\Campaign;
use Illuminate\Support\Facades\Auth;

class DonationController extends Controller
{
    // Show the general donation page
    public function general()
    {
        $campaigns = Campaign::all();
        return view('donations.general', compact('campaigns'));
    }

    // Show donation form for a specific campaign
    public function create(Campaign $campaign)
    {
        return view('donations.form', compact('campaign'));
    }

    // Store a donation
    public function store(Request $request)
    {
        $validated = $request->validate([
            'campaign_id' => 'required|exists:campaigns,id',
            'amount' => 'required|numeric|min:1',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'address' => 'nullable|string|max:500',
            'payment_method' => 'required|string',
            'cover_fee' => 'nullable|boolean',
        ]);

        $donation = new Donation();
        $donation->user_id = Auth::id();
        $donation->campaign_id = $validated['campaign_id'];
        $donation->amount = $validated['amount'];
        $donation->first_name = $validated['first_name'];
        $donation->last_name = $validated['last_name'];
        $donation->email = $validated['email'];
        $donation->address = $validated['address'] ?? '';
        $donation->payment_method = $validated['payment_method'];
        $donation->cover_fee = $request->has('cover_fee') ? 1 : 0;
        $donation->save();

        // Update campaign raised amount
        $campaign = Campaign::find($validated['campaign_id']);
        $campaign->current_amount += $validated['amount'];
        $campaign->save();

        return redirect()->back()->with('success', 'Thank you for your donation!');
    }
}
