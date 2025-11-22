<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Donation;
use App\Models\Campaign;
use Illuminate\Support\Facades\Auth;

class DonationsController extends Controller
{
    // // Show general donations page
    // public function general()
    // {
    //     $campaigns = Campaign::all();
    //     return view('donations.general', compact('campaigns'));
    // }

    // Show donation form for a specific campaign
    public function create(Campaign $campaign)
    {
        return view('donations.form', compact('campaign'));
    }

    // Store a donation
    public function store(Request $request)
    {
        // Validate the donation input
        $validated = $request->validate([
            'campaign_id' => 'required|exists:campaigns,id',
            'amount' => 'required|numeric|min:1',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'address' => 'nullable|string|max:500',
            'payment_method' => 'required|string',
            'mobile_money_provider' => 'nullable|string',
            'cover_fee' => 'nullable|boolean',
        ]);

        // Create a new donation
        $donation = new Donation();
        $donation->user_id = Auth::id();
        $donation->campaign_id = $validated['campaign_id'];
        $donation->amount = $validated['amount'];
        $donation->first_name = $validated['first_name'];
        $donation->last_name = $validated['last_name'];
        $donation->email = $validated['email'];
        $donation->address = $validated['address'] ?? '';
        $donation->payment_method = $validated['payment_method'];
        $donation->mobile_money_provider = $validated['mobile_money_provider'] ?? null;
        $donation->cover_fee = $request->has('cover_fee') ? 1 : 0;
        $donation->save();

        // Update campaign raised amount
        $campaign = Campaign::find($validated['campaign_id']);
        $campaign->current_amount += $validated['amount'];
        $campaign->save();

        // Redirect to the success page instead of back
        return redirect()->route('donation.success')->with('success', 'Thank you for your donation!');
    }

    // Show success page after donation
    public function success()
    {
        return view('donations.success'); // Ensure this view exists
    }
}
