<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TravelEasy | Nieuw account toevoegen</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Barlow:wght@400;500;600;700&family=Space+Grotesk:wght@500;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
    <style>
        .account-create-shell {
            width: min(100% - 2rem, 1180px);
            margin: 1rem auto 0;
        }

        .account-create-topbar {
            border: 1px solid #cfe1f3;
            border-radius: 16px;
            background: #f8fbff;
            padding: 0.75rem 1rem;
            display: grid;
            grid-template-columns: auto 1fr auto;
            gap: 0.9rem;
            align-items: center;
        }

        .account-create-nav {
            text-align: center;
            font-family: 'Space Grotesk', sans-serif;
            font-weight: 700;
            color: #173f66;
        }

        .account-overview-btn {
            text-decoration: none;
            border: 1px solid #275782;
            border-radius: 10px;
            padding: 0.55rem 0.9rem;
            color: #17456d;
            background: #ffffff;
            font-weight: 700;
            white-space: nowrap;
        }

        .account-overview-btn:hover {
            background: #edf5ff;
        }

        .account-create-main {
            border: 1px solid #cfe1f3;
            border-radius: 16px;
            background: #f8fbff;
            min-height: 66vh;
            margin-top: 0.9rem;
            padding: 1.4rem 1rem 2rem;
            display: grid;
            align-content: center;
        }

        .account-create-wrap {
            width: min(100%, 860px);
            margin: 0 auto;
        }

        .account-create-title {
            margin: 0 0 0.85rem;
            text-align: center;
            font-family: 'Space Grotesk', sans-serif;
            font-size: clamp(1.25rem, 2vw, 1.7rem);
            color: #173f66;
        }

        .account-create-form {
            display: grid;
            gap: 0.5rem;
        }

        .field-row {
            border: 1px solid #acc6e0;
            border-radius: 8px;
            background: #ffffff;
            display: grid;
            gap: 0.35rem;
            padding: 0.7rem 0.9rem;
        }

        .field-row label {
            font-weight: 700;
            color: #214f78;
            text-align: center;
        }

        .field-row input,
        .field-row select {
            width: 100%;
            border: 1px solid #c4d8eb;
            border-radius: 6px;
            padding: 0.62rem 0.75rem;
            font-size: 1rem;
            font-family: 'Barlow', sans-serif;
            outline: none;
            color: #102a42;
        }

        .field-row input:focus,
        .field-row select:focus {
            border-color: #5a91c4;
            box-shadow: 0 0 0 3px rgba(90, 145, 196, 0.18);
        }

        .field-error {
            color: #7d1f1f;
            font-size: 0.9rem;
            font-weight: 600;
        }

        .create-submit {
            margin-top: 0.45rem;
            border: 1px solid #2b5880;
            border-radius: 8px;
            padding: 0.8rem;
            background: #ffffff;
            color: #1d4f7b;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
        }

        .create-submit:hover {
            background: #edf5ff;
        }

        .account-create-footer {
            margin-top: 0.9rem;
            border: 1px solid #cfe1f3;
            border-radius: 16px;
            background: #f8fbff;
            display: grid;
            grid-template-columns: auto 1fr;
            align-items: center;
            gap: 1rem;
            padding: 0.7rem 1rem;
        }

        .account-create-footer-text {
            text-align: center;
            font-family: 'Space Grotesk', sans-serif;
            font-weight: 700;
            color: #173f66;
        }

        @media (max-width: 760px) {
            .account-create-topbar {
                grid-template-columns: auto 1fr;
            }

            .account-create-nav {
                grid-column: 1 / -1;
                order: 3;
            }

            .account-create-main {
                min-height: 58vh;
            }
        }
    </style>
</head>

<body>
    <div class="account-create-shell">
        <header class="account-create-topbar">
            <div class="logo-circle">TravelEasy</div>
            <a class="home-btn" href="{{ route('home') }}">Home</a>
            <a class="account-overview-btn" href="{{ route('accounts.index') }}">Terug naar Account Overzicht</a>
        </header>

        <main class="account-create-main">
            <section class="account-create-wrap">
                <h1 class="account-create-title">Nieuw account toevoegen</h1>

                @if ($errors->any())
                    <div class="alert alert-error" role="alert">
                        {{ $errors->first() }}
                    </div>
                @endif

                @include('partials.flash')

                <form class="account-create-form" action="{{ route('accounts.store') }}" method="post">
                    @csrf

                    <div class="field-row">
                        <label for="name">GebruiksNaam</label>
                        <input id="name" name="name" type="text" value="{{ old('name') }}" required>
                        @error('name')
                            <span class="field-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="field-row">
                        <label for="email">Email</label>
                        <input id="email" name="email" type="email" value="{{ old('email') }}" required>
                        @error('email')
                            <span class="field-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="field-row">
                        <label for="password">Wachtwoord</label>
                        <input id="password" name="password" type="password" required>
                        @error('password')
                            <span class="field-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="field-row">
                        <label for="password_confirmation">Wachtwoord Bevestigen</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" required>
                    </div>

                    <div class="field-row">
                        <label for="role">Rol</label>
                        <select id="role" name="role" required>
                            <option value="">Kies een rol</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role }}" @selected(old('role') === $role)>{{ $role }}
                                </option>
                            @endforeach
                        </select>
                        @error('role')
                            <span class="field-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <button class="create-submit" type="submit">Toevoegen</button>
                </form>
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
    </div>
</body>

</html>
