<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'TravelEasy')</title>
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
</head>
<body>
    <header>
        <h1>TravelEasy</h1>
    </header>
    <main>
        @yield('content')
    </main>
</body>
</html>
