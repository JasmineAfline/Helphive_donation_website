<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Campaign;

class CampaignController extends Controller
{
    // List all campaigns
    public function index()
    {
        $campaigns = Campaign::all(); // get all campaigns
        return view('campaigns.index', compact('campaigns'));
    }

    // Show single campaign
    public function show($id)
    {
        $campaign = Campaign::findOrFail($id);
        return view('campaigns.show', compact('campaign'));
    }
}

