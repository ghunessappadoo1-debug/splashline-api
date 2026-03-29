@extends('layouts.app')

@section('content')

<div class="min-h-screen flex flex-col items-center justify-between">
    
    <!-- Navigation Bar (Fixed) -->
    <nav class="glass px-8 py-4 w-full flex items-center justify-between rounded-none shadow-lg fixed top-0 left-0 z-50">
        <div class="flex items-center gap-3">
    <img src="{{ asset('images/logo_design.png') }}" alt="SplashLine Logo" class="w-20 h-14 object-contain">
    
</div>
        
        <div class="hidden md:flex gap-8 text-sm font-medium">
            <a href="/exhibits" class="flex flex-col items-center gap-1 opacity-80 hover:opacity-100"><i class="fas fa-water"></i> Exhibits</a>
            <a href="/animals" class="flex flex-col items-center gap-1 opacity-80 hover:opacity-100"><i class="fas fa-fish"></i> Animals</a>
            <a href="/visitors" class="flex flex-col items-center gap-1 opacity-80 hover:opacity-100"><i class="fas fa-users"></i> Visitors</a>
            <a href="/bookings" class="flex flex-col items-center gap-1 opacity-80 hover:opacity-100"><i class="fas fa-book-open"></i> Bookings</a>
            <a href="/tours" class="flex flex-col items-center gap-1 opacity-80 hover:opacity-100"><i class="fas fa-bus"></i> Tours</a>
            <a href="/feeding-schedules" class="flex flex-col items-center gap-1 opacity-80 hover:opacity-100"><i class="fas fa-clock"></i> Feeding</a>
        </div>

        <div class="flex items-center gap-4">
            <a href="/bookings" class="bg-white/20 hover:bg-white/30 px-6 py-2 rounded-full text-sm font-semibold transition">Buy Tickets Now <i class="fas fa-chevron-right ml-2 text-xs"></i></a>
            <i class="fas fa-bars md:hidden text-xl cursor-pointer"></i>
        </div>
    </nav>

    <!-- Content Wrapper (Added pt-28 to account for fixed nav height) -->
    <div class="flex flex-col items-center w-full px-6 gap-20 pt-28">
        <!-- Hero Section -->
        <div class="text-center max-w-2xl mt-10">
            <h1 class="text-6xl font-extrabold mb-4">Welcome to SplashLine</h1>
            <p class="text-lg opacity-80 mb-8">Dive into a new world of marine discovery – manage exhibits, animals, and visitor experiences all in one place.</p>
            <div class="flex justify-center gap-4">
                <a href="/exhibits" class="bg-blue-600 hover:bg-blue-700 px-8 py-3 rounded-lg font-semibold transition">Explore Exhibits</a>
                <a href="/bookings" class="bg-white/10 hover:bg-white/20 border border-white/30 px-8 py-3 rounded-lg font-semibold transition">Book Tickets</a>
            </div>
        </div>

        <!-- Feature Cards -->
        <div class="grid md:grid-cols-3 gap-6 w-full max-w-6xl">
            <div class="glass p-8 text-center flex flex-col items-center transform hover:scale-105 transition">
                <i class="fas fa-water text-3xl mb-4 text-teal-300"></i>
                <h3 class="text-2xl font-bold mb-2">Exhibits</h3>
                <p class="text-sm opacity-70 mb-6">Discover breathtaking marine habitats reefs to penguin colonies.</p>
                <a href="/exhibits" class="w-full bg-white/10 hover:bg-white/20 py-2 rounded-md transition text-center block">Manage Exhibits</a>
            </div>

            <div class="glass p-8 text-center flex flex-col items-center transform hover:scale-105 transition border-t-2 border-teal-400">
                <i class="fas fa-fish text-3xl mb-4 text-teal-300"></i>
                <h3 class="text-2xl font-bold mb-2">Animals</h3>
                <p class="text-sm opacity-70 mb-6">Meet our dolphins, sharks, and turtles, and colorful fish.</p>
                <a href="/animals" class="w-full bg-teal-500/30 hover:bg-teal-500/50 py-2 rounded-md transition text-center block">View Animals</a>
            </div>

            <div class="glass p-8 text-center flex flex-col items-center transform hover:scale-105 transition">
                <i class="fas fa-calendar-check text-3xl mb-4 text-teal-300"></i>
                <h3 class="text-2xl font-bold mb-2">Bookings</h3>
                <p class="text-sm opacity-70 mb-6">Plan your visit, book tickets, join behind-the-scenes tours.</p>
                <a href="/bookings" class="w-full bg-white/10 hover:bg-white/20 py-2 rounded-md transition text-center block">Book Now</a>
            </div>
        </div>

        <!-- Footer -->
        <footer class="w-full flex justify-between items-center opacity-60 text-sm border-t border-white/10 pt-6 pb-10">
            <div class="flex items-center gap-4">
                <img src="{{ asset('images/logo_design.png') }}" alt="" class="w-6 h-6 opacity-50">
                <div class="flex gap-6">
                    <i class="fab fa-facebook"></i> <i class="fab fa-instagram"></i> <i class="fab fa-linkedin"></i> <i class="fab fa-x-twitter"></i>
                </div>
            </div>
            <p>© 2026 SplashLine. All rights reserved.</p>
            <p class="hidden md:block italic">Dive into the deep blue.</p>
        </footer>
    </div>
</div>
@endsection
