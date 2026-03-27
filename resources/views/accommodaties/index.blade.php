<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TravelEasy | Accommodaties</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow:wght@400;500;600;700&family=Space+Grotesk:wght@500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
    <style>
        .accommodaties-shell {
            width: min(100% - 2rem, 1080px);
            margin: 1.2rem auto 2rem;
        }

        .accommodaties-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            margin-bottom: 0.9rem;
            flex-wrap: wrap;
        }

        .accommodaties-head h1 {
            margin: 0;
            font-family: 'Space Grotesk', sans-serif;
            font-size: 1.7rem;
            color: #173f66;
        }

        .accommodaties-back {
            text-decoration: none;
            color: #1f578a;
            font-weight: 700;
        }

        .accommodaties-back:hover {
            text-decoration: underline;
            text-underline-offset: 2px;
        }

        .accommodaties-actions {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            flex-wrap: wrap;
        }

        .accommodaties-create {
            text-decoration: none;
            border-radius: 999px;
            border: 0;
            padding: 0.52rem 0.9rem;
            color: #ffffff;
            font-weight: 700;
            background: linear-gradient(160deg, #0f67d8, #0b4da7);
        }

        .accommodaties-create:hover {
            filter: brightness(1.05);
        }

        .accommodaties-table-wrap {
            border: 1px solid #d3e2f3;
            border-radius: 14px;
            overflow: auto;
            background: #ffffff;
            box-shadow: 0 18px 35px rgba(9, 42, 77, 0.1);
        }

        .accommodaties-table {
            width: 100%;
            border-collapse: collapse;
            min-width: 760px;
        }

        .accommodaties-table th,
        .accommodaties-table td {
            text-align: left;
            padding: 0.75rem 0.9rem;
            border-bottom: 1px solid #e2ebf7;
            font-size: 0.95rem;
        }

        .accommodaties-table th {
            color: #23517d;
            background: #eff6ff;
            font-family: 'Space Grotesk', sans-serif;
            font-size: 0.93rem;
        }

        .accommodaties-table tr:last-child td {
            border-bottom: 0;
        }
    </style>
</head>
<body>
<div class="accommodaties-shell">
    <div class="accommodaties-head">
        <h1>Accommodaties</h1>
        <div class="accommodaties-actions">
            <a class="accommodaties-create" href="{{ route('accommodaties.create') }}">Nieuwe accommodatie toevoegen</a>
            <a class="accommodaties-back" href="{{ route('home') }}">Terug naar home</a>
        </div>
    </div>

    @include('partials.flash')

    <div class="accommodaties-table-wrap">
        <table class="accommodaties-table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Naam</th>
                <th>Type</th>
                <th>Locatie</th>
                <th>Prijs per nacht</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($accommodaties as $accommodatie)
                <tr>
                    <td>{{ $accommodatie->Id }}</td>
                    <td>{{ $accommodatie->naam }}</td>
                    <td>{{ $accommodatie->type }}</td>
                    <td>{{ $accommodatie->locatie }}</td>
                    <td>&euro; {{ number_format($accommodatie->prijs_per_nacht, 2, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">Geen accommodaties gevonden.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
</body>
</html>