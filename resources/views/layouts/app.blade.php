<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SplashLine – Marine Park Management</title>
    <!-- Bootstrap 5 + Font Awesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @stack('styles')
</head>
<body>
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="fas fa-fish"></i> SplashLine
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
                style="background: var(--teal); color: white;">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ route('exhibits') }}"><i class="fas fa-water"></i> Exhibits</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('animals') }}"><i class="fas fa-paw"></i> Animals</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('visitors') }}"><i class="fas fa-users"></i> Visitors</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('bookings') }}"><i class="fas fa-ticket-alt"></i> Bookings</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('tours') }}"><i class="fas fa-ship"></i> Tours</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('feeding-schedules') }}"><i class="fas fa-clock"></i> Feeding</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer>
        <div class="wave"></div>
        <div class="container text-center py-4">
            <p>&copy; 2026 SplashLine. All rights reserved. Dive into the deep blue.</p>
            <div>
                <i class="fab fa-facebook-f me-3"></i>
                <i class="fab fa-instagram me-3"></i>
                <i class="fab fa-twitter"></i>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const API_BASE = '/api/v1';
    </script>
    @stack('scripts')
</body>
</html>