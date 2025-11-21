<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Campaign;
use Illuminate\Support\Facades\Validator;

class CampaignController extends Controller
{
    // List all campaigns
    public function index()
    {
        $campaigns = Campaign::all();
        return view('admin.campaigns.index', compact('campaigns'));
    }

    // Show a single campaign
    public function show($id)
    {
        $campaign = Campaign::findOrFail($id);
        return view('admin.campaigns.show', compact('campaign'));
    }

    // Show the form for creating a new campaign
    public function create()
    {
        return view('admin.campaigns.create');
    }

    // Store a newly created campaign in storage
    public function store(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'goal_amount' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.campaigns.create')
                ->withErrors($validator)
                ->withInput();
        }

        // Create a new campaign
        Campaign::create($request->all());

        return redirect()->route('admin.campaigns.index')->with('success', 'Campaign created successfully.');
    }

    // Show the form for editing the specified campaign
    public function edit($id)
    {
        $campaign = Campaign::findOrFail($id);
        return view('admin.campaigns.edit', compact('campaign'));
    }

    // Update the specified campaign in storage
    public function update(Request $request, $id)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'goal_amount' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.campaigns.edit', $id)
                ->withErrors($validator)
                ->withInput();
        }

        // Find the campaign and update its details
        $campaign = Campaign::findOrFail($id);
        $campaign->update($request->all());

        return redirect()->route('admin.campaigns.index')->with('success', 'Campaign updated successfully.');
    }

    // Remove the specified campaign from storage
    public function destroy($id)
    {
        $campaign = Campaign::findOrFail($id);
        $campaign->delete();

        return redirect()->route('admin.campaigns.index')->with('success', 'Campaign deleted successfully.');
    }
}
