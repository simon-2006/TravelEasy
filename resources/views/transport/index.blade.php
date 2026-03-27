<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TravelEasy | Transport</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow:wght@400;500;600;700&family=Space+Grotesk:wght@500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
    <style>
        .transport-shell {
            width: min(100% - 2rem, 1080px);
            margin: 1.2rem auto 2rem;
        }

        .transport-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            margin-bottom: 0.9rem;
            flex-wrap: wrap;
        }

        .transport-head h1 {
            margin: 0;
            font-family: 'Space Grotesk', sans-serif;
            font-size: 1.7rem;
            color: #173f66;
        }

        .transport-back {
            text-decoration: none;
            color: #1f578a;
            font-weight: 700;
        }

        .transport-back:hover {
            text-decoration: underline;
            text-underline-offset: 2px;
        }

        .transport-actions {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            flex-wrap: wrap;
        }

        .transport-create {
            text-decoration: none;
            border-radius: 999px;
            border: 0;
            padding: 0.52rem 0.9rem;
            color: #ffffff;
            font-weight: 700;
            background: linear-gradient(160deg, #0f67d8, #0b4da7);
        }

        .transport-create:hover {
            filter: brightness(1.05);
        }

        .transport-table-wrap {
            border: 1px solid #d3e2f3;
            border-radius: 14px;
            overflow: auto;
            background: #ffffff;
            box-shadow: 0 18px 35px rgba(9, 42, 77, 0.1);
        }

        .transport-table {
            width: 100%;
            border-collapse: collapse;
            min-width: 760px;
        }

        .transport-table th,
        .transport-table td {
            text-align: left;
            padding: 0.75rem 0.9rem;
            border-bottom: 1px solid #e2ebf7;
            font-size: 0.95rem;
        }

        .transport-table th {
            color: #23517d;
            background: #eff6ff;
            font-family: 'Space Grotesk', sans-serif;
            font-size: 0.93rem;
        }

        .transport-table tr:last-child td {
            border-bottom: 0;
        }
    </style>
</head>
<body>
<div class="transport-shell">
    <div class="transport-head">
        <h1>Transport Overzicht</h1>
        <div class="transport-actions">
            <a class="transport-create" href="{{ route('transport.create') }}">Nieuw transport</a>
            <a class="transport-back" href="{{ route('home') }}">Terug naar home</a>
        </div>
    </div>

    @include('partials.flash')

    <div class="transport-table-wrap">
        <table class="transport-table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Type</th>
                <th>Maatschappij</th>
                <th>Vertrekplaats</th>
                <th>Aankomstplaats</th>
                <th>Prijs</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($transporten as $transport)
                <tr>
                    <td>{{ $transport->id }}</td>
                    <td>{{ ucfirst($transport->type) }}</td>
                    <td>{{ $transport->maatschappij }}</td>
                    <td>{{ $transport->vertrekplaats }}</td>
                    <td>{{ $transport->aankomstplaats }}</td>
                    <td>&euro; {{ number_format($transport->prijs, 2, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">Geen transporten gevonden.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
</body>
</html>