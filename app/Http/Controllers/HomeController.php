<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Campaign;

class HomeController extends Controller
{
    public function index()
    {
        // Get latest campaigns to display on home page
        $campaigns = Campaign::latest()->take(6)->get(); // adjust number if needed

        return view('home', compact('campaigns'));
    }
}
