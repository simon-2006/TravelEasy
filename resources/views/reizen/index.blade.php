<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reizen</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow:wght@400;500;600;700&family=Space+Grotesk:wght@500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f3f3f3;
            margin: 0;
            color: #0d2238;
        }

        .pagina-wrapper {
            max-width: 1440px;
            margin: 0 auto;
            padding: 30px 40px 40px;
        }

        .navbar-wrapper {
            margin-bottom: 40px;
        }

        .reizen-container {
            max-width: 1100px;
            margin: 0 auto;
        }

        h1 {
            margin-bottom: 30px;
            text-align: center;
        }

        .foutmelding {
            color: red;
            margin-bottom: 20px;
        }

        .succesmelding {
            color: green;
            margin-bottom: 20px;
        }

        .leegmelding {
            background: white;
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #ddd;
        }

        .knop-balk {
            margin-bottom: 20px;
            text-align: left;
        }

        .toevoegen-knop {
            display: inline-block;
            background: #0d2238;
            color: white;
            text-decoration: none;
            padding: 12px 18px;
            border-radius: 8px;
        }

        .reis-lijst {
            display: flex;
            flex-direction: column;
            gap: 18px;
        }

        .reis-kaart {
            display: grid;
            grid-template-columns: 1.8fr 1fr 1fr 1fr;
            align-items: center;
            gap: 20px;
            background-color: #e9e9e9;
            padding: 26px 24px;
            border-radius: 4px;
            text-decoration: none;
            color: inherit;
            transition: 0.2s ease;
            border: 1px solid #dddddd;
        }

        .reis-kaart:hover {
            background-color: #dfdfdf;
        }

        .afbeelding-blok {
            display: flex;
            align-items: center;
            gap: 18px;
        }

        .reis-afbeelding {
            width: 96px;
            height: 96px;
            object-fit: cover;
            border-radius: 12px;
            background-color: #ccc;
            flex-shrink: 0;
        }

        .reis-info h2 {
            margin: 0 0 8px;
            font-size: 22px;
            font-weight: bold;
        }

        .reis-info p {
            margin: 0;
            font-size: 17px;
            color: #24384b;
        }

        .promo-badge {
            display: inline-block;
            padding: 12px 22px;
            border: 2px solid #3d8dff;
            border-radius: 999px;
            color: #0c3b67;
            font-weight: bold;
            font-size: 18px;
            background-color: white;
            width: fit-content;
        }

        .soort-reis {
            font-size: 18px;
            color: #10283d;
        }

        .prijs {
            text-align: right;
            font-weight: bold;
            font-size: 20px;
            color: #091d30;
        }

        .geen-promo {
            visibility: hidden;
        }

        @media (max-width: 1100px) {
            .reis-kaart {
                grid-template-columns: 1fr;
                text-align: left;
            }

            .prijs {
                text-align: left;
            }
        }
    </style>
</head>
<body>

    <div class="pagina-wrapper">
        <div class="navbar-wrapper">
            <header class="container topbar reveal">
                <div class="logo-circle">TravelEasy</div>

                <nav class="nav-links" aria-label="Navbar">
                    <a href="{{ route('home') }}">Home</a>
                    <a href="#">Bestemmingen</a>
                    <a href="{{ route('reizen.index') }}">Reizen</a>
                    <a href="#">Contact</a>

                    @guest
                        <a href="{{ route('login') }}">Login</a>
                        <a href="{{ route('register') }}">Registreren</a>
                    @endguest

                    @auth
                        <span class="nav-user">
                            Hallo, {{ auth()->user()->name }} ({{ auth()->user()->role }})
                        </span>

                        @if (auth()->user()->canViewAccountOverview())
                            <a href="{{ route('accounts.index') }}">Accountoverzicht</a>
                        @endif

                        @if (auth()->user()->canManageDashboard())
                            <a href="{{ route('management.index') }}">Dashboard beheren</a>
                        @endif

                        <a href="{{ route('klanten.index') }}">Klanten</a>

                        <form class="nav-logout-form" action="{{ route('logout') }}" method="post">
                            @csrf
                            <button class="nav-logout-btn" type="submit">Logout</button>
                        </form>
                    @endauth
                </nav>
            </header>
        </div>

        <div class="reizen-container">
            <h1>Overzicht van reizen</h1>

            @if(session('success'))
                <p class="succesmelding">{{ session('success') }}</p>
            @endif

            <div class="knop-balk">
                <a href="{{ route('reizen.create') }}" class="toevoegen-knop">
                    Reis toevoegen
                </a>
            </div>

            @if(session('error'))
                <p class="foutmelding">{{ session('error') }}</p>
            @endif

            @if($reizen->isEmpty())
                <div class="leegmelding">
                    Er zijn nog geen reizen toegevoegd.
                </div>
            @else
                <div class="reis-lijst">
                    @foreach($reizen as $reis)
                        <a href="{{ route('reizen.show', ['id' => $reis->id]) }}" class="reis-kaart">
                            <div class="afbeelding-blok">
                                @if($reis->afbeelding)
                                    <img src="{{ asset('images/' . $reis->afbeelding) }}" alt="{{ $reis->titel }}" class="reis-afbeelding">
                                @else
                                    <div class="reis-afbeelding"></div>
                                @endif

                                <div class="reis-info">
                                    <h2>{{ $reis->titel }}</h2>
                                    <p>({{ $reis->land ?? 'Onbekend land' }})</p>
                                </div>
                            </div>

                            <div>
                                @if($reis->promo)
                                    <span class="promo-badge">Promo tarief</span>
                                @else
                                    <span class="geen-promo">Promo tarief</span>
                                @endif
                            </div>

                            <div class="soort-reis">
                                ↔ {{ $reis->soort_reis ?? 'Retour' }}
                            </div>

                            <div class="prijs">
                                Vanaf EUR {{ number_format($reis->prijs, 0, ',', '.') }}*
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
