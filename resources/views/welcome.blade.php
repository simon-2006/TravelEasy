<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TravelEasy | Home</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow:wght@400;500;600;700&family=Space+Grotesk:wght@500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}?v={{ filemtime(public_path('css/welcome.css')) }}">
</head>
<body>
<header class="container topbar reveal">
    <div class="logo-circle">TravelEasy</div>
    <button class="nav-toggle" type="button" aria-label="Open navigatie" aria-controls="primary-nav" aria-expanded="false" data-nav-toggle>
        <span class="nav-toggle-bar"></span>
        <span class="nav-toggle-bar"></span>
        <span class="nav-toggle-bar"></span>
    </button>
    <nav id="primary-nav" class="nav-links" aria-label="Navbar" data-nav-links hidden>
        <a href="{{ route('home') }}">Home</a>
        <a href="#">Bestemmingen</a>
        <a href="{{ route('reizen.index') }}">Reizen</a>
        <a href="{{ route('accommodaties.index') }}">Accommodaties</a>
        <a href="#">Contact</a>
        
        @guest
            <a href="{{ route('login') }}">Login</a>
            <a href="{{ route('register') }}">Registreren</a>
        @endguest
        @auth
            <span class="nav-user">Hallo, {{ auth()->user()->name }} ({{ auth()->user()->role }})</span>
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

<div class="container flash-stack reveal delay-1">
    @include('partials.flash')
</div>

<main class="container">
    <section class="hero reveal delay-1">
        <div class="hero-copy">
            <div class="hero-kicker">TravelEasy</div>
            <h1>Plan je volgende vlucht en reis in een paar klikken.</h1>
            <p>Vergelijk vluchten, hotels en vervoer op een plek. Snel zoeken, direct boeken en zorgeloos vertrekken.</p>
        </div>
        <div class="hero-image">
            <img src="{{ asset('images/FB-vliegtuig.jpg') }}" alt="Illustratie van vliegtuig en reisbestemming">
        </div>
    </section>

    <section class="service-tabs reveal delay-1" aria-label="Reisdiensten">
        <button type="button">Slapen</button>
        <button type="button">Vlucht</button>
        <button type="button">Vlucht + Hotel</button>
        <button type="button">Auto Lenen</button>
        <button type="button">Taxi Airport</button>
    </section>

    <section class="search-area reveal delay-2">
        <h2>Plan jouw reis op de homepagina</h2>
        <form class="search-form" action="#" method="get">
            <label class="field">
                <span>Bestemming (stad)</span>
                <input type="text" name="bestemming" placeholder="Bijv. Barcelona">
            </label>
            <label class="field">
                <span>Selecteer land</span>
                <select name="land">
                    <option value="">Kies een land</option>
                    @foreach ($groupedCountries as $letter => $countries)
                        <optgroup label="{{ $letter }}">
                            @foreach ($countries as $country)
                                <option value="{{ $country['code'] }}">{{ $country['name'] }}</option>
                            @endforeach
                        </optgroup>
                    @endforeach
                </select>
            </label>
            <label class="field">
                <span>Vertrekdatum</span>
                <input type="date" name="vertrekdatum">
            </label>
            <label class="field">
                <span>Terugkomstdatum</span>
                <input type="date" name="terugkomstdatum">
            </label>
            <label class="field">
                <span>Aantal Personen</span>
                <input type="number" name="personen" min="1" value="2">
            </label>
            <button class="search-btn" type="submit">Zoek Reis</button>
        </form>
    </section>

    <section class="why reveal delay-3">
        <h2>Waarom heb jij voor ons gekozen</h2>
        <div class="why-card">
            <p>
                Bij TravelEasy geloven we dat reizen een van de meest verrijkende ervaringen in het leven is. Daarom hebben we een platform gecreÃ«erd dat niet alleen gebruiksvriendelijk is, maar ook een breed scala aan opties biedt om aan al jouw reisbehoeften te voldoen. Of je nu op zoek bent naar de beste deals, unieke bestemmingen of een naadloze boekingservaring, wij staan klaar om je te helpen bij elke stap van je reisplanning. Met onze toewijding aan klanttevredenheid en onze passie voor reizen, streven we ernaar om jouw volgende avontuur onvergetelijk te maken.
            </p>
        </div>
    </section>

    <section class="explore reveal delay-4">
        <div class="explore-top">
            <button class="ghost-btn" type="button">Opzoek Naar</button>
        </div>

        <div class="cards">
            <article class="card">
                <img src="{{ asset('images/anantara_jewel-bagh_jaipur_hotel_teaser_01_880x620.webp') }}" alt="Hotels bestemming">
                <h3>Hotels</h3>
            </article>
            <article class="card">
                <img src="{{ asset('images/949_1440x960.avif') }}" alt="Apartments bestemming">
                <h3>Apartments</h3>
            </article>
            <article class="card">
                <img src="{{ asset('images/venetianvilla-posarellivillas-1-.jpg') }}" alt="Villas bestemming">
                <h3>Villas</h3>
            </article>
        </div>
    </section>
</main>

<footer class="footer">
    <div class="container footer-shell">
        <div class="footer-top">
            <section class="footer-brand">
                <div class="logo-circle footer-logo">TravelEasy</div>
                <p>
                    Jouw reispartner voor vluchten, hotels en vervoer. Alles op een plek,
                    zodat je sneller kunt plannen en zorgeloos kunt vertrekken.
                </p>
                <div class="footer-socials" aria-label="Sociale media">
                    <a href="#" aria-label="Instagram">Instagram</a>
                    <a href="#" aria-label="TikTok">TikTok</a>
                    <a href="#" aria-label="YouTube">YouTube</a>
                    <a href="#" aria-label="LinkedIn">LinkedIn</a>
                </div>
            </section>

            <nav class="footer-col" aria-label="Snelle links">
                <h3>Snelle links</h3>
                <a href="#">Home</a>
                <a href="#">Bestemmingen</a>
                <a href="#">Vluchtdeals</a>
                <a href="#">Hotels</a>
                <a href="#">Autoverhuur</a>
            </nav>

            <section class="footer-col" aria-label="Ondersteuning">
                <h3>Ondersteuning</h3>
                <a href="#">Helpcentrum</a>
                <a href="#">Boeking beheren</a>
                <a href="#">Annuleren</a>
                <a href="#">Contact</a>
                <p class="footer-contact">support@traveleasy.nl<br>+31 20 123 45 67</p>
            </section>

            <form class="footer-newsletter" action="#" method="post">
                <h3>Nieuwsbrief</h3>
                <p>Ontvang wekelijks nieuwe deals en reistips in je inbox.</p>
                <div class="newsletter-row">
                    <input type="email" name="email" placeholder="jouw@email.nl" required>
                    <button type="submit">Aanmelden</button>
                </div>
                <p class="footer-note">Geen spam. Uitschrijven kan altijd.</p>
            </form>
        </div>

        <div class="footer-bottom">
            <p class="footer-copy">&copy; {{ date('Y') }} TravelEasy. Alle rechten voorbehouden.</p>
            <div class="footer-badges" aria-label="Footer kenmerken">
                <span>SSL beveiligd</span>
                <span>24/7 Support</span>
                <span>Transparante prijzen</span>
            </div>
        </div>
    </div>
</footer>
<script>
    (function () {
        var BREAKPOINT = 1280;
        var toggle = document.querySelector('[data-nav-toggle]');
        var nav = document.querySelector('[data-nav-links]');

        if (!toggle || !nav) {
            return;
        }

        function isMobile() {
            return window.matchMedia('(max-width: ' + BREAKPOINT + 'px)').matches;
        }

        function setOpenState(open) {
            nav.classList.toggle('is-open', open);
            nav.hidden = isMobile() ? !open : false;

            toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
            toggle.setAttribute('aria-label', open ? 'Sluit navigatie' : 'Open navigatie');
        }

        function syncWithViewport() {
            var mobile = isMobile();

            toggle.hidden = !mobile;

            if (!mobile) {
                setOpenState(false);
                nav.hidden = false;
            } else if (!nav.classList.contains('is-open')) {
                nav.hidden = true;
            }
        }

        toggle.addEventListener('click', function () {
            setOpenState(!nav.classList.contains('is-open'));
        });

        nav.addEventListener('click', function (event) {
            if (!isMobile()) {
                return;
            }

            var target = event.target;

            if (!(target instanceof HTMLElement)) {
                return;
            }

            if (target.closest('a, button')) {
                setOpenState(false);
            }
        });

        window.addEventListener('resize', syncWithViewport);
        syncWithViewport();
    })();
</script>
</body>
</html>
