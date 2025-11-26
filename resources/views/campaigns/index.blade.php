@extends('layouts.app')

@section('content')

<h2 class="text-3xl font-extrabold mb-8 text-red-600 text-center">
    HelpHive Campaigns
</h2>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

    @foreach($campaigns as $campaign)

        @php
            // --- SMART IMAGE MATCHING ---
            // Normalize strings
            $normalize = function ($str) {
                $str = strtolower($str);
                $str = str_replace(['-', '_'], ' ', $str);
                $str = preg_replace('/[^a-z0-9\s]/', '', $str);
                return preg_replace('/\s+/', ' ', trim($str));
            };

            $titleNorm = $normalize($campaign->title);
            $tokens = explode(' ', $titleNorm);

            $bestImage = null;
            $bestScore = -1;

            foreach ($images as $img) {
                $imgName = pathinfo($img, PATHINFO_FILENAME);
                $imgNorm = $normalize($imgName);

                // Token match score
                $tokenMatches = 0;
                foreach ($tokens as $t) {
                    if ($t !== '' && str_contains($imgNorm, $t)) {
                        $tokenMatches++;
                    }
                }

                // Similarity percentages
                similar_text($titleNorm, $imgNorm, $percent);
                $lev = levenshtein($titleNorm, $imgNorm);
                $maxLen = max(strlen($titleNorm), strlen($imgNorm), 1);
                $levScore = max(0, 100 - intval(($lev / $maxLen) * 100));

                // Final score
                $score = ($percent * 0.6) + ($levScore * 0.25) + ($tokenMatches * 10);

                if ($tokenMatches >= max(1, ceil(count($tokens) / 2))) {
                    $score += 20; // strong boost if filename contains most title words
                }

                if ($score > $bestScore) {
                    $bestScore = $score;
                    $bestImage = $img;
                }
            }

            // Accept match only if score is decent
            $image = $bestScore >= 25 ? $bestImage : null;

            // If still nothing → fallback random
            if (!$image && count($images) > 0) {
                $image = $images[array_rand($images)];
            }
        @endphp

        <div class="bg-white rounded-2xl shadow-md border border-red-200 overflow-hidden">
            
            @if($image)
                <img src="{{ asset('images/campaigns/' . $image) }}"
                     class="h-48 w-full object-cover"
                     alt="{{ $campaign->title }}">
            @else
                <div class="h-48 w-full bg-gray-200 flex items-center justify-center text-gray-500">
                    No Image Available
                </div>
            @endif

            <div class="p-6">
                <h3 class="text-xl font-bold text-red-600 mb-2">{{ $campaign->title }}</h3>

                <p class="text-gray-700 mb-3">{{ Str::limit($campaign->description, 120) }}</p>

                <p class="text-sm text-gray-500">
                    <strong>Goal:</strong> ${{ number_format($campaign->goal_amount, 2) }}
                </p>

                <p class="text-sm text-gray-500 mb-4">
                    <strong>Raised:</strong> ${{ number_format($campaign->current_amount, 2) }}
                </p>

                <a href="{{ route('donate.campaign', $campaign->id) }}"
                   class="mt-4 inline-block bg-red-600 text-white px-4 py-2 rounded-full hover:bg-red-700 transition">
                    Donate
                </a>
            </div>
        </div>

    @endforeach

</div>

@endsection
