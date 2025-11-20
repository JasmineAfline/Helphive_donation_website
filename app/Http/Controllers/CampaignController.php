<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Campaign;

class CampaignController extends Controller
{
    // List all campaigns
    public function index()
    {
        $campaigns = Campaign::all();
        return view('campaigns.index', compact('campaigns'));
    }

    // Show a single campaign
    public function show($id)
    {
        $campaign = Campaign::findOrFail($id);
        return view('campaigns.show', compact('campaign'));
    }

    // Optional for admin CRUD
    public function create() {}
    public function store(Request $request) {}
    public function edit($id) {}
    public function update(Request $request, $id) {}
    public function destroy($id) {}
}
