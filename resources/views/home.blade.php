@extends('layouts.app')

@section('content')
    <div class="hero">
        <div class="container">
            <h1 class="display-3">Welcome to SplashLine</h1>
            <p class="lead">Experience the magic of the ocean – manage exhibits, animals, and visitor experiences all in one place.</p>
            <a href="{{ route('exhibits') }}" class="btn btn-primary btn-lg me-2">Explore Exhibits</a>
            <a href="{{ route('bookings') }}" class="btn btn-outline-light btn-lg">Book Tickets</a>
        </div>
    </div>

    <div class="container my-5">
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card p-3 text-center">
                    <i class="fas fa-water fa-3x mb-3" style="color: var(--teal);"></i>
                    <h3>Exhibits</h3>
                    <p>Discover breathtaking marine habitats from tropical reefs to penguin colonies.</p>
                    <a href="{{ route('exhibits') }}" class="btn btn-primary">Manage Exhibits</a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-3 text-center">
                    <i class="fas fa-fish fa-3x mb-3" style="color: var(--teal);"></i>
                    <h3>Animals</h3>
                    <p>Meet our dolphins, sharks, sea turtles, and thousands of colorful fish.</p>
                    <a href="{{ route('animals') }}" class="btn btn-primary">View Animals</a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-3 text-center">
                    <i class="fas fa-ticket-alt fa-3x mb-3" style="color: var(--teal);"></i>
                    <h3>Bookings</h3>
                    <p>Plan your visit, book tickets, and join behind‑the‑scenes tours.</p>
                    <a href="{{ route('bookings') }}" class="btn btn-primary">Book Now</a>
                </div>
            </div>
        </div>
    </div>
@endsection