<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Campaign;   // ← IMPORTANT

class CampaignSeeder extends Seeder
{
    public function run()
    {
        Campaign::create([
            'title' => 'Help Orphaned Kids',
            'description' => 'Support children with food & school supplies.',
            'goal_amount' => 50000,
            'current_amount' => 0,
        ]);
    }
}
