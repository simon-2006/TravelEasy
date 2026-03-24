<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TravelEasy | Klantenoverzicht</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow:wght@400;500;600;700&family=Space+Grotesk:wght@500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<header class="container topbar reveal">
    <div class="logo-circle">TravelEasy</div>
    <nav class="nav-links" aria-label="Navbar">
        <a href="{{ route('home') }}">Home</a>
        <a href="#">Bestemmingen</a>
        <a href="#">Vlucht Deals</a>
        <a href="#">Contact</a>
        @auth
            <span class="nav-user">Hallo</span>
            <a href="{{ route('accounts.index') }}">Accountoverzicht</a>
            <a href="{{ route('management.index') }}">Dashboard beheren</a>
            <a href="{{ route('klanten.index') }}" class="active">Klanten</a>
            <form class="nav-logout-form" action="{{ route('logout') }}" method="post">
                @csrf
                <button class="nav-logout-btn" type="submit">Logout</button>
            </form>
        @endauth
        @guest
            <a href="{{ route('login') }}">Login</a>
            <a href="{{ route('register') }}">Registreren</a>
        @endguest
    </nav>
</header>
<div class="container flash-stack reveal delay-1">
    @include('partials.flash')
</div>
<main class="container">
    @include('klanten.index')
</main>
</body>
</html>
