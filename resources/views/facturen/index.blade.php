<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TravelEasy | Facturen</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow:wght@400;500;600;700&family=Space+Grotesk:wght@500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
    <style>
        .invoices-shell {
            width: min(100% - 2rem, 1080px);
            margin: 1.2rem auto 2rem;
        }

        .invoices-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            margin-bottom: 0.9rem;
            flex-wrap: wrap;
        }

        .invoices-head h1 {
            margin: 0;
            font-family: 'Space Grotesk', sans-serif;
            font-size: 1.7rem;
            color: #173f66;
        }

        .invoices-back {
            text-decoration: none;
            color: #1f578a;
            font-weight: 700;
        }

        .invoices-back:hover {
            text-decoration: underline;
            text-underline-offset: 2px;
        }

        .invoices-actions {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            flex-wrap: wrap;
        }

        .invoices-create {
            text-decoration: none;
            border-radius: 999px;
            border: 0;
            padding: 0.52rem 0.9rem;
            color: #ffffff;
            font-weight: 700;
            background: linear-gradient(160deg, #0f67d8, #0b4da7);
        }

        .invoices-create:hover {
            filter: brightness(1.05);
        }

        .invoices-table-wrap {
            border: 1px solid #d3e2f3;
            border-radius: 14px;
            overflow: auto;
            background: #ffffff;
            box-shadow: 0 18px 35px rgba(9, 42, 77, 0.1);
        }

        .invoices-table {
            width: 100%;
            border-collapse: collapse;
            min-width: 760px;
        }

        .invoices-table th,
        .invoices-table td {
            text-align: left;
            padding: 0.75rem 0.9rem;
            border-bottom: 1px solid #e2ebf7;
            font-size: 0.95rem;
        }

        .invoices-table th {
            color: #23517d;
            background: #eff6ff;
            font-family: 'Space Grotesk', sans-serif;
            font-size: 0.93rem;
        }

        .invoices-table tr:last-child td {
            border-bottom: 0;
        }
    </style>
</head>
<body>
<div class="invoices-shell">
    <div class="invoices-head">
        <h1>Facturen Overzicht</h1>
        <div class="invoices-actions">
            <a class="invoices-create" href="{{ route('facturen.create') }}">Nieuwe factuur toevoegen</a>
            <a class="invoices-back" href="{{ route('home') }}">Terug naar home</a>
        </div>
    </div>

    @include('partials.flash')

    <div class="invoices-table-wrap">
        <table class="invoices-table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Boeking ID</th>
                <th>Totaalbedrag</th>
                <th>Status</th>
                <th>Datum Factuur</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($facturen as $factuur)
                <tr>
                    <td>{{ $factuur->Id }}</td>
                    <td>{{ $factuur->boekingId }}</td>
                    <td>&euro; {{ number_format($factuur->totaal_bedrag, 2, ',', '.') }}</td>
                    <td>{{ $factuur->betaald ? 'Betaald' : 'Onbetaald' }}</td>
                    <td>{{ $factuur->datum_factuur ?? 'N.v.t.' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">Geen facturen gevonden.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
</body>
</html>