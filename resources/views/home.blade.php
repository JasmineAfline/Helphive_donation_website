@extends('layouts.app')

@section('content')

{{-- The outer section now has a larger bottom padding to ensure spacing (pb-24) --}}
{{-- We moved the relative positioning to the next container to manage the absolute overlay --}}
<section class="bg-gray-900 pb-24 relative">
    @php
        use Illuminate\Support\Str;

        // Build carousel items from campaigns (up to 3 distinct images)
        $carouselItems = [];
        if (isset($campaigns) && count($campaigns)) {
            foreach ($campaigns as $c) {
                if (count($carouselItems) >= 3) break;
                if (empty($c->image)) continue;

                // resolve image path preference: public images, storage, or direct
                if (Str::startsWith($c->image, 'images/') || Str::startsWith($c->image, '/images/')) {
                    $imgPath = asset(ltrim($c->image, '/'));
                } elseif (file_exists(public_path('storage/' . $c->image))) {
                    $imgPath = asset('storage/' . $c->image);
                } else {
                    $imgPath = asset($c->image);
                }

                // avoid duplicate image paths
                $exists = false;
                foreach ($carouselItems as $ci) {
                    if (($ci['image'] ?? null) === $imgPath) { $exists = true; break; }
                }
                if ($exists) continue;

                $carouselItems[] = [
                    'image' => $imgPath,
                    'title' => $c->title,
                    'text' => Str::limit($c->description ?? '', 120),
                ];
            }
        }

        // Fallback images (distinct) if campaigns don't provide enough
        $defaults = [
            [
                'image' => asset('images/campaigns/foodbank.jpg'),
                'title' => 'Volunteers Delivering Aid',
                'text' => 'Teams distributing food, water, and medical supplies to communities in need.'
            ],
            [
                'image' => asset('images/campaigns/clean_water.jpg'),
                'title' => 'Clean Water Initiatives',
                'text' => 'Providing safe water and sanitation for vulnerable communities.'
            ],
            [
                'image' => asset('images/campaigns/children_medical_aid.jpg'),
                'title' => 'Children Medical Aid',
                'text' => 'Healthcare programs supporting children and families.'
            ],
        ];

        foreach ($defaults as $d) {
            if (count($carouselItems) >= 3) break;
            $exists = false;
            foreach ($carouselItems as $ci) { if (($ci['image'] ?? null) === $d['image']) { $exists = true; break; } }
            if (!$exists) $carouselItems[] = $d;
        }
    @endphp

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        <div class="relative overflow-hidden rounded-b-3xl shadow-2xl">
            <div id="carousel" class="relative h-[60vh] md:h-[70vh] lg:h-[75vh]">
                @foreach($carouselItems as $i => $item)
                {{-- Added duration-1000 for smoother transition, opacity is managed by JS --}}
                <div class="carousel-slide absolute inset-0 opacity-0 scale-95 transform transition-all duration-1000 ease-in-out">
                    <img src="{{ $item['image'] }}" alt="slide-{{ $i }}" class="w-full h-full object-cover brightness-75">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                    <div class="absolute left-6 md:left-16 top-1/3 md:top-1/3 text-left text-white max-w-2xl">
                        <h2 class="text-3xl md:text-5xl font-extrabold leading-tight">{{ $item['title'] }}</h2>
                        <p class="mt-4 text-sm md:text-lg text-gray-200">{{ $item['text'] }}</p>
                        <a href="{{ route('campaigns.index') }}" class="mt-6 inline-flex items-center justify-center rounded-full px-6 py-3 text-white font-semibold bg-red-600 hover:bg-red-700 transition shadow-lg focus:outline-none focus:ring-4 focus:ring-red-300 text-base">
                            View Campaigns
                        </a>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="absolute inset-y-0 left-0 right-0 flex items-center justify-between px-4 sm:px-6 z-30">
                <button id="prev" class="bg-black/30 hover:bg-black/50 text-white rounded-full p-3 backdrop-blur-sm transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                </button>
                <button id="next" class="bg-black/30 hover:bg-black/50 text-white rounded-full p-3 backdrop-blur-sm transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10l-3.293-3.293a1 1 0 111.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>
                </button>
            </div>
            
            {{-- Subtle indicators --}}
            <div id="carousel-indicators" class="absolute bottom-4 left-1/2 transform -translate-x-1/2 z-30 flex space-x-2">
                @foreach($carouselItems as $i => $item)
                    <button class="indicator w-3 h-3 bg-white/50 rounded-full transition-all duration-300" data-index="{{ $i }}"></button>
                @endforeach
            </div>
        </div>
    </div>
    <div class="absolute right-6 bottom-6 text-white text-sm opacity-80 z-20 hidden md:block">Sliding stories of impact • Smooth transitions</div>
</section>

<main class="-mt-16 relative z-20 pb-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <section class="lg:col-span-2 bg-white rounded-2xl shadow-xl p-8 transition-shadow duration-300 hover:shadow-2xl">
                <div class="flex items-center justify-between border-b pb-4 mb-6">
                    <h2 class="text-3xl font-extrabold text-gray-800">Active Campaigns</h2>
                    <a href="{{ route('campaigns.index') }}" class="text-red-600 font-semibold hover:text-red-700 transition-colors flex items-center gap-1">
                        View all
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                    </a>
                </div>

                <div class="mt-6 grid sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    @forelse($campaigns as $campaign)
                        <article class="group bg-white rounded-xl overflow-hidden shadow-lg transform transition-all duration-300 hover:scale-[1.02] hover:shadow-2xl border border-gray-100">
                            <a href="{{ route('campaigns.show', $campaign->id) }}">
                                <div class="relative h-40">
              @php
    // Fallback images for campaigns without images
    $fallbacks = [
        asset('images/campaigns/new-home_for_low_income_families.jpg'), // Housing
        asset('images/campaigns/youths_programmes.jpg'),               // Youths
        asset('images/campaigns/senior_citizens_care.jpg'),           // Senior Citizens
        asset('images/campaigns/environmental_conservation.jpg'),     // Environmental Conservation
        asset('images/campaigns/community_tech_access.jpg'),          // Community Tech
        asset('images/campaigns/children_medical_aid.jpg'),           // Emergency Medical Aid
        asset('images/campaigns/disaster_relief_kit.jpg'),
        asset('images/campaigns/community_food_assistance.jpg'),
    ];

    $img = null;

    if (!empty($campaign->image)) {
        if (\Illuminate\Support\Str::startsWith($campaign->image, 'images/') || \Illuminate\Support\Str::startsWith($campaign->image, '/images/')) {
            $img = asset(ltrim($campaign->image, '/'));
        } elseif (file_exists(public_path('storage/' . $campaign->image))) {
            $img = asset('storage/' . $campaign->image);
        } else {
            $img = asset($campaign->image);
        }
    } else {
        // Rotate fallback images based on campaign ID
        $img = $fallbacks[$campaign->id % count($fallbacks)];
    }
@endphp

                                    <img src="{{ $img }}" alt="{{ $campaign->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 ease-in-out">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                                    <div class="absolute left-3 bottom-3 text-white">
                                        <h3 class="font-extrabold text-lg leading-snug">{{ Str::limit($campaign->title, 40) }}</h3>
                                    </div>
                                </div>
                            </a>
                        </article>
                    @empty
                        <p class="text-gray-500 lg:col-span-3 py-6 text-center">There are currently no active campaigns. Check back soon!</p>
                    @endforelse
                </div>
            </section>

            <aside class="bg-white rounded-2xl shadow-xl p-8 h-fit sticky top-8 border border-gray-100">
                <h3 class="text-2xl font-extrabold text-gray-800 border-b pb-4 mb-6">Quick Donation</h3>
                <p class="text-sm text-gray-600 mt-1">Make a fast, secure donation via M-Pesa to our general fund.</p>

                <form id="quickDonateForm" class="mt-6 space-y-5">
                    @csrf
                    <div>
                        <label for="amount" class="block text-sm font-semibold text-gray-700">Amount (KES)</label>
                        <input id="amount" name="amount" type="number" min="10" required class="mt-1 block w-full rounded-xl border border-gray-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500" placeholder="1000">
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-semibold text-gray-700">Phone (07xxxxxxxx)</label>
                        <input id="phone" name="phone" type="tel" pattern="07[0-9]{8}" required class="mt-1 block w-full rounded-xl border border-gray-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500" placeholder="0712345678">
                    </div>

                    <div>
                        <button id="donateBtn" type="button" class="w-full inline-flex items-center justify-center gap-2 rounded-xl px-4 py-3 text-white font-bold text-lg bg-gradient-to-r from-red-600 to-pink-500 hover:from-red-700 hover:to-pink-600 transition-all duration-300 shadow-xl focus:outline-none focus:ring-4 focus:ring-red-300 disabled:opacity-75 disabled:cursor-not-allowed">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor"><path d="M3 3a1 1 0 011-1h3a1 1 0 010 2H5v12h2a1 1 0 110 2H4a1 1 0 01-1-1V3z"/><path d="M13 7a1 1 0 00-1 1v3H9a1 1 0 100 2h3v3a1 1 0 102 0v-3h3a1 1 0 100-2h-3V8a1 1 0 00-1-1z"/></svg>
                            Donate via M-Pesa
                        </button>
                    </div>

                    <p id="donateMessage" class="text-sm text-center text-red-500 mt-2 hidden"></p>
                </form>

                <div class="mt-6 text-xs text-gray-400 text-center">By donating you agree to our <a href="#" class="text-red-600 hover:underline">terms</a> and <a href="#" class="text-red-600 hover:underline">privacy policy</a>.</div>
            </aside>

        </div>
    </div>
</main>

{{-- Include carousel and donation JS here as in your original file --}}
<script>
    (function () {
        const slides = Array.from(document.querySelectorAll('.carousel-slide'));
        const indicators = Array.from(document.querySelectorAll('.indicator'));
        let index = 0;
        if (slides.length === 0) return;

        function show(i) {
            slides.forEach((s, idx) => {
                s.classList.toggle('opacity-100', idx === i);
                s.classList.toggle('scale-100', idx === i);
                s.classList.toggle('opacity-0', idx !== i);
                s.classList.toggle('scale-95', idx !== i);
                s.style.zIndex = idx === i ? 20 : 10;
            });
            indicators.forEach((ind, idx) => {
                ind.classList.toggle('bg-white', idx === i);
                ind.classList.toggle('bg-white/50', idx !== i);
            });
        }

        document.getElementById('next').addEventListener('click', function () {
            index = (index + 1) % slides.length; show(index);
        });

        document.getElementById('prev').addEventListener('click', function () {
            index = (index - 1 + slides.length) % slides.length; show(index);
        });
        
        indicators.forEach(indicator => {
            indicator.addEventListener('click', function() {
                index = parseInt(this.dataset.index);
                show(index);
            });
        });

        show(index);
        setInterval(() => { index = (index + 1) % slides.length; show(index); }, 6000);

        // Donate form AJAX Logic
        const donateBtn = document.getElementById('donateBtn');
        const amountInput = document.getElementById('amount');
        const phoneInput = document.getElementById('phone');
        const msg = document.getElementById('donateMessage');

        donateBtn.addEventListener('click', () => {
            const amount = amountInput.value.trim();
            const phone = phoneInput.value.trim();
            if (amount < 10 || !phone || phone.length !== 10 || !phone.startsWith('07')) {
                msg.textContent = 'Please provide a valid amount (KES 10+) and a Safaricom number (07xxxxxxxx).';
                msg.classList.remove('hidden', 'text-green-500');
                msg.classList.add('text-red-500');
                return;
            }

            donateBtn.disabled = true;
            donateBtn.innerHTML = '<svg class="animate-spin h-5 w-5 mr-3" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Sending Request...';
            msg.classList.add('hidden');

            fetch("{{ route('mpesa.donate') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                },
                body: JSON.stringify({ amount, phone, campaign_id: null })
            }).then(r => {
                if (!r.ok) throw new Error(`HTTP error! status: ${r.status}`);
                return r.json();
            }).then(data => {
                donateBtn.disabled = false;
                donateBtn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor"><path d="M3 3a1 1 0 011-1h3a1 1 0 010 2H5v12h2a1 1 0 110 2H4a1 1 0 01-1-1V3z"/><path d="M13 7a1 1 0 00-1 1v3H9a1 1 0 100 2h3v3a1 1 0 102 0v-3h3a1 1 0 100-2h-3V8a1 1 0 00-1-1z"/></svg>Donate via M-Pesa';
                
                msg.classList.remove('hidden');
                if (data.success) { 
                    msg.textContent = data.message || 'STK Push sent! Check your phone.';
                    msg.classList.remove('text-red-500'); 
                    msg.classList.add('text-green-500'); 
                } else {
                    msg.textContent = data.message || 'Something went wrong. Try again.';
                    msg.classList.remove('text-green-500');
                    msg.classList.add('text-red-500');
                }
            }).catch(err => {
                donateBtn.disabled = false;
                donateBtn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor"><path d="M3 3a1 1 0 011-1h3a1 1 0 010 2H5v12h2a1 1 0 110 2H4a1 1 0 01-1-1V3z"/><path d="M13 7a1 1 0 00-1 1v3H9a1 1 0 100 2h3v3a1 1 0 102 0v-3h3a1 1 0 100-2h-3V8a1 1 0 00-1-1z"/></svg>Donate via M-Pesa';
                msg.textContent = 'Error sending request. Please try again.';
                msg.classList.remove('hidden');
                msg.classList.add('text-red-500');
            });
        });
    })();
</script>

@endsection
