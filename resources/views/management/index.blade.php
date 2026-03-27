<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TravelEasy | Dashboard beheren</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow:wght@400;500;600;700&family=Space+Grotesk:wght@500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
    <style>
        .management-shell {
            width: min(100% - 2rem, 1080px);
            margin: 1.2rem auto 2rem;
        }

        .management-head {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            gap: 1rem;
            flex-wrap: wrap;
            margin-bottom: 1rem;
        }

        .management-head h1 {
            margin: 0;
            font-family: 'Space Grotesk', sans-serif;
            color: #173f66;
            font-size: 1.7rem;
        }

        .management-card {
            border: 1px solid #d3e2f3;
            border-radius: 14px;
            background: #ffffff;
            padding: 1.2rem;
            box-shadow: 0 18px 35px rgba(9, 42, 77, 0.1);
        }

        .management-card h2 {
            margin: 0 0 0.6rem;
            font-family: 'Space Grotesk', sans-serif;
            color: #173f66;
        }

        .management-card p {
            margin: 0 0 1rem;
            color: #3f5d79;
            max-width: 62ch;
        }

        .management-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 999px;
            border: 0;
            padding: 0.7rem 1.1rem;
            color: #ffffff;
            text-decoration: none;
            font-weight: 700;
            background: linear-gradient(160deg, #0f67d8, #0b4da7);
        }

        .management-btn:hover {
            filter: brightness(1.05);
        }

        .management-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 0.6rem;
        }

        .management-btn-secondary {
            border: 1px solid #b7d0ea;
            color: #1f578a;
            background: #f3f8ff;
        }

        @media (max-width: 640px) {
            .management-actions {
                flex-direction: column;
                align-items: stretch;
            }

            .management-actions .management-btn {
                width: 100%;
            }
        }
    </style>
</head>
<body>
<div class="management-shell">
    <div class="management-head">
        <h1>Dashboard beheren</h1>
    </div>

    @include('partials.flash')

    <section class="management-card">
        <h2>Boekingen monitoren</h2>
        <p>Bekijk per datum hoeveel boekingen er zijn geplaatst, inclusief trend en status per bestemming.</p>
        <div class="management-actions">
            <a class="management-btn" href="{{ route('management.bookings') }}">Aantal Boeking Bekijken</a>
            <a class="management-btn" href="{{ route('management.revenue') }}">Omzet bekijken</a>
            <a class="management-btn management-btn-secondary" href="{{ route('accounts.index') }}">Ga naar accountoverzicht</a>
            <a class="management-btn management-btn-secondary" href="{{ route('home') }}">Home</a>
        </div>
    </section>
</div>
</body>
</html>
