<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TravelEasy | Inloggen</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow:wght@400;500;600;700&family=Space+Grotesk:wght@500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
    <style>
        .auth-body {
            margin: 0;
            min-height: 100vh;
            font-family: 'Barlow', sans-serif;
            background: linear-gradient(160deg, #f2f8ff 0%, #e7f3ff 100%);
            color: #102942;
            display: grid;
            place-items: center;
            padding: 1.2rem;
        }

        .auth-wrap {
            width: min(100%, 460px);
        }

        .auth-home {
            display: inline-block;
            margin-bottom: 0.9rem;
            color: #245787;
            font-weight: 600;
            text-decoration: none;
        }

        .auth-home:hover {
            text-decoration: underline;
            text-underline-offset: 2px;
        }

        .auth-card {
            border: 1px solid #cde0f6;
            border-radius: 16px;
            background: #ffffff;
            padding: 1.3rem;
            box-shadow: 0 16px 32px rgba(9, 42, 77, 0.12);
        }

        .auth-card h1 {
            margin: 0;
            font-family: 'Space Grotesk', sans-serif;
            font-size: 1.6rem;
        }

        .auth-card p {
            margin: 0.45rem 0 1rem;
            color: #476482;
        }

        .auth-form {
            display: grid;
            gap: 0.8rem;
        }

        .auth-form label {
            display: grid;
            gap: 0.35rem;
            font-weight: 600;
            color: #2f506f;
            font-size: 0.95rem;
        }

        .auth-form input {
            border: 1px solid #c7dced;
            border-radius: 10px;
            padding: 0.7rem 0.8rem;
            font-size: 1rem;
            outline: none;
        }

        .auth-form input:focus {
            border-color: #4d8ecf;
            box-shadow: 0 0 0 3px rgba(77, 142, 207, 0.18);
        }

        .auth-btn {
            border: 0;
            border-radius: 10px;
            padding: 0.75rem 1rem;
            font-size: 1rem;
            font-weight: 700;
            color: #ffffff;
            background: linear-gradient(160deg, #0f67d8, #0b4da7);
            cursor: pointer;
        }

        .auth-btn:hover {
            filter: brightness(1.05);
        }
    </style>
</head>
<body class="auth-body">
<main class="auth-wrap">
    <a class="auth-home" href="{{ route('home') }}">Terug naar home</a>

    <section class="auth-card">
        <h1>Inloggen</h1>
        <p>Gebruik je gebruikersnaam of e-mail met je wachtwoord.</p>

        @if ($errors->any())
            <div class="alert alert-error" role="alert">
                {{ $errors->first() }}
            </div>
        @endif

        @include('partials.flash')

        <form class="auth-form" action="{{ route('login.attempt') }}" method="post">
            @csrf
            <label>
                Gebruikersnaam of e-mail
                <input type="text" name="login" value="{{ old('login') }}" required autofocus>
            </label>

            <label>
                Wachtwoord
                <input type="password" name="password" required>
            </label>

            <button class="auth-btn" type="submit">Inloggen</button>
        </form>

        <p style="margin: 0.85rem 0 0; color: #4a6785; font-size: 0.92rem;">
            Nog geen account? <a href="{{ route('register') }}" style="color:#155284;font-weight:700;text-decoration:none;">Registreren</a>
        </p>
    </section>
</main>
</body>
</html>
