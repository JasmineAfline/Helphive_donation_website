<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Donation;
use App\Models\Campaign;
use Illuminate\Support\Facades\Auth;

class DonationsController extends Controller
{
    // Show donation form for a specific campaign
    public function create(Campaign $campaign)
    {
        return view('donations.form', compact('campaign'));
    }

    // Store initial donation details and go to phone entry page
    public function store(Request $request)
    {
        $validated = $request->validate([
            'campaign_id' => 'required|exists:campaigns,id',
            'amount' => 'required|numeric|min:1',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'payment_method' => 'required|string',
        ]);

        // Save donation info temporarily in session
        session([
            'donation_data' => $validated,
            'donation_user_id' => Auth::id(),
        ]);

        // Redirect to phone number entry page
       return redirect()->route('mpesa.checkout', $validated['campaign_id']);

    }

    // Show phone number form
    public function phone()
    {
        return view('donations.phone');
    }

    // Show success AFTER M-Pesa confirms payment
    public function success()
    {
        return view('donations.success');
    }
}
