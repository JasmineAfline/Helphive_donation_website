
@extends('layouts.app')

@section('title', 'About HelpHive')

@section('content')
<div class="bg-gray-50 py-16 md:py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Hero Section: Mission Statement --}}
        <header class="text-center mb-16">
            <h1 class="text-5xl md:text-6xl font-extrabold text-gray-900 mb-4 leading-tight">
                Empowering Change. One Donation.
            </h1>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                HelpHive connects humanity with purpose. We are dedicated to making charitable giving simple, transparent, and profoundly impactful across the globe.
            </p>
        </header>

        {{-- Core Focus Section --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-20">
            
            {{-- Focus 1: Orphaned Children --}}
            <div class="text-center p-8 bg-white rounded-xl shadow-lg border-t-4 border-red-600 transition hover:shadow-xl">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-red-600 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292V15l-2 2h4l-2 2v2M15 17h6m-3-3l3 3m0 0l-3 3"/></svg>
                <h3 class="text-2xl font-bold text-gray-800 mb-3">Helping Children</h3>
                <p class="text-gray-600">We prioritize campaigns providing safe shelter, education, and nutrition for orphaned and vulnerable children.</p>
            </div>

            {{-- Focus 2: Communities in Need --}}
            <div class="text-center p-8 bg-white rounded-xl shadow-lg border-t-4 border-indigo-600 transition hover:shadow-xl">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-indigo-600 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5h-15a1.5 1.5 0 000 3h15a1.5 1.5 0 000-3z" /></svg>
                <h3 class="text-2xl font-bold text-gray-800 mb-3">Community Support</h3>
                <p class="text-gray-600">Supporting grassroots efforts to deliver essential resources like clean water, healthcare, and infrastructure to struggling communities.</p>
            </div>

            {{-- Focus 3: Empowering Youth --}}
            <div class="text-center p-8 bg-white rounded-xl shadow-lg border-t-4 border-green-600 transition hover:shadow-xl">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-green-600 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                <h3 class="text-2xl font-bold text-gray-800 mb-3">Youth Empowerment</h3>
                <p class="text-gray-600">Funding vocational training, skills development, and scholarship programs to equip young people for a successful future.</p>
            </div>
        </div>
        
        {{-- Our Pledge Section (Transparency) --}}
        <div class="bg-red-50 p-10 rounded-xl shadow-inner border border-red-200">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-center">
                <div>
                    <h2 class="text-3xl font-bold text-red-800 mb-4">Our Pledge: Transparency and Trust</h2>
                    <p class="text-lg text-red-700 mb-4">
                        We believe that every donor deserves to know exactly where their money goes. 
                        HelpHive utilizes cutting-edge tracking to ensure **100% accountability** for all funds raised.
                    </p>
                    <p class="text-red-700">
                        We work only with vetted organizations that demonstrate measurable results and ethical financial practices. Your donation creates real, tangible change.
                    </p>
                </div>
                <div class="flex justify-center lg:justify-end">
                    <a href="{{ route('campaigns.index') }}" class="inline-flex items-center px-8 py-4 bg-red-600 text-white text-lg font-semibold rounded-full shadow-lg hover:bg-red-700 transition duration-300 transform hover:scale-105">
                        Start Making an Impact Today &rarr;
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection