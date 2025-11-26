<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Campaign;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class CampaignController extends Controller
{
    /**
     * Return the campaigns list and a smart mapping of campaign_id => image filename
     */
    public function index()
    {
        $campaigns = Campaign::all();

        // Read images from public/images/campaigns
        $folder = public_path('images/campaigns');
        $images = File::exists($folder)
            ? collect(File::files($folder))
                ->filter(fn($f) => in_array(strtolower($f->getExtension()), ['jpg','jpeg','png','webp','gif']))
                ->map(fn($f) => $f->getFilename())
                ->values()
                ->all()
            : [];

        // Build mapping campaign_id => best matching image filename (or null)
        $campaignImageMap = [];
        foreach ($campaigns as $campaign) {
            $campaignImageMap[$campaign->id] = $this->getBestImageMatch($campaign->title, $images);
        }

        return view('campaigns.index', compact('campaigns', 'images', 'campaignImageMap'));
    }

    /**
     * Smart matching function:
     *  - normalize strings (lowercase, remove punctuation)
     *  - try exact/substring filename contains title words
     *  - score with similar_text, fallback to levenshtein normalized
     *  - returns filename or null
     */
    protected function getBestImageMatch(string $title, array $images)
    {
        if (empty($images)) return null;

        // normalize title to tokens
        $normTitle = $this->normalize($title);
        $titleTokens = array_filter(explode(' ', $normTitle));

        $best = null;
        $bestScore = -1;

        foreach ($images as $img) {
            $nameNoExt = pathinfo($img, PATHINFO_FILENAME);
            $normImg = $this->normalize($nameNoExt);

            // 1) Word-match boost: count how many title tokens appear in filename
            $tokenMatches = 0;
            foreach ($titleTokens as $tkn) {
                if ($tkn === '') continue;
                if (str_contains($normImg, $tkn)) $tokenMatches++;
            }

            // 2) Base similarity percent using similar_text
            similar_text($normTitle, $normImg, $percent); // sets $percent (0-100)

            // 3) Levenshtein normalized (lower is better) - convert to score (0-100)
            $lev = levenshtein($normTitle, $normImg);
            // Normalize: max length between the two
            $maxLen = max(mb_strlen($normTitle), mb_strlen($normImg), 1);
            $levScore = max(0, 100 - intval(($lev / $maxLen) * 100));

            // 4) Combined score: give more weight to tokenMatches and similar_text
            $score = ($percent * 0.6) + ($levScore * 0.25) + ($tokenMatches * 10);

            // If filename contains all tokens, give heavy boost
            if (!empty($titleTokens) && $tokenMatches >= max(1, ceil(count($titleTokens) / 2))) {
                $score += 20;
            }

            // Keep best
            if ($score > $bestScore) {
                $bestScore = $score;
                $best = $img;
            }
        }

        // Threshold: require some reasonable score (e.g., 25) to accept match, else null
        return $bestScore >= 25 ? $best : null;
    }

    protected function normalize(string $s): string
    {
        // Lowercase, remove punctuation, replace separators with spaces, collapse spaces
        $s = mb_strtolower($s);
        // replace dashes/underscores with spaces
        $s = str_replace(['-', '_'], ' ', $s);
        // remove non-alphanum (but keep spaces)
        $s = preg_replace('/[^a-z0-9\s]/u', '', $s);
        // collapse spaces
        $s = preg_replace('/\s+/', ' ', $s);
        return trim($s);
    }

    // Keep other controller methods (show/create/store/edit/update/destroy) unchanged if you have them.
}
