<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TravelEasy | Omzet bekijken</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow:wght@400;500;600;700&family=Space+Grotesk:wght@500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
    <style>
        .revenue-shell {
            width: min(100% - 2rem, 1120px);
            margin: 1.2rem auto 2rem;
        }

        .revenue-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            flex-wrap: wrap;
            margin-bottom: 0.9rem;
        }

        .revenue-head h1 {
            margin: 0;
            font-family: 'Space Grotesk', sans-serif;
            color: #173f66;
            font-size: 1.7rem;
        }

        .revenue-actions {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .revenue-link {
            text-decoration: none;
            color: #1f578a;
            font-weight: 700;
            border: 1px solid #c5daf0;
            border-radius: 999px;
            padding: 0.5rem 0.8rem;
            background: #f4f9ff;
        }

        .revenue-link:hover {
            background: #e8f3ff;
        }

        .revenue-card {
            border: 1px solid #d3e2f3;
            border-radius: 14px;
            background: #ffffff;
            padding: 1rem;
            box-shadow: 0 18px 35px rgba(9, 42, 77, 0.1);
            margin-bottom: 1rem;
        }

        .revenue-card h2 {
            margin: 0 0 0.7rem;
            font-family: 'Space Grotesk', sans-serif;
            color: #173f66;
        }

        .revenue-form {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 0.8rem;
            align-items: end;
        }

        .revenue-field {
            display: grid;
            gap: 0.35rem;
        }

        .revenue-field label {
            font-size: 0.88rem;
            color: #214c76;
            font-weight: 700;
        }

        .revenue-field select,
        .revenue-field input {
            border: 1px solid #bfd6ee;
            border-radius: 10px;
            padding: 0.58rem 0.68rem;
            font: inherit;
            color: #163a5e;
            background: #fafdff;
        }

        .revenue-submit {
            border: 0;
            border-radius: 999px;
            padding: 0.68rem 0.98rem;
            color: #ffffff;
            background: linear-gradient(160deg, #0f67d8, #0b4da7);
            font-weight: 700;
            cursor: pointer;
        }

        .revenue-submit:hover {
            filter: brightness(1.05);
        }

        .revenue-meta {
            margin-top: 0.8rem;
            color: #28547e;
            font-weight: 600;
        }

        .revenue-error-list {
            margin: 0 0 0.8rem;
            padding: 0.8rem 0.9rem;
            border: 1px solid #f2b2b2;
            border-radius: 12px;
            background: #fff4f4;
            color: #7f1717;
        }

        .revenue-summary {
            margin-bottom: 0.9rem;
            border: 1px solid #d3e2f3;
            border-radius: 14px;
            background: #ffffff;
            padding: 0.8rem 1rem;
            box-shadow: 0 16px 32px rgba(9, 42, 77, 0.1);
        }

        .revenue-summary p {
            margin: 0;
            font-weight: 700;
            color: #194a77;
        }

        .revenue-table-wrap {
            border: 1px solid #d3e2f3;
            border-radius: 14px;
            overflow: auto;
            background: #ffffff;
            box-shadow: 0 18px 35px rgba(9, 42, 77, 0.1);
        }

        .revenue-table {
            width: 100%;
            border-collapse: collapse;
            min-width: 760px;
        }

        .revenue-table th,
        .revenue-table td {
            text-align: left;
            padding: 0.75rem 0.9rem;
            border-bottom: 1px solid #e2ebf7;
            font-size: 0.95rem;
        }

        .revenue-table th {
            color: #23517d;
            background: #eff6ff;
            font-family: 'Space Grotesk', sans-serif;
            font-size: 0.93rem;
        }

        .revenue-table tr:last-child td {
            border-bottom: 0;
        }

        .revenue-empty {
            margin: 0;
            color: #7c2a2a;
            font-weight: 700;
        }

        @media (max-width: 600px) {
            .revenue-form {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
<div class="revenue-shell">
    <div class="revenue-head">
        <h1>Omzet bekijken</h1>
        <div class="revenue-actions">
            <a class="revenue-link" href="{{ route('management.index') }}">Dashboard beheren</a>
            @if (auth()->user()?->canViewAccountOverview())
                <a class="revenue-link" href="{{ route('accounts.index') }}">Accountoverzicht</a>
            @else
                <a class="revenue-link" href="{{ route('home') }}">Home</a>
            @endif
        </div>
    </div>

    @include('partials.flash')

    @if ($errors->any())
        <div class="revenue-error-list">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <section class="revenue-card">
        <h2>Omzet van het bedrijf</h2>
        <form class="revenue-form" method="get" action="{{ route('management.revenue') }}">
            <div class="revenue-field">
                <label for="periode">Periode selecteren</label>
                <select id="periode" name="periode">
                    <option value="deze_week" @selected($selectedPeriod === 'deze_week')>Deze week</option>
                    <option value="deze_maand" @selected($selectedPeriod === 'deze_maand')>Deze maand</option>
                    <option value="dit_kwartaal" @selected($selectedPeriod === 'dit_kwartaal')>Dit kwartaal</option>
                    <option value="dit_jaar" @selected($selectedPeriod === 'dit_jaar')>Dit jaar</option>
                    <option value="aangepast" @selected($selectedPeriod === 'aangepast')>Aangepaste periode</option>
                </select>
            </div>
            <div class="revenue-field">
                <label for="van_datum">Van datum</label>
                <input id="van_datum" name="van_datum" type="date" value="{{ old('van_datum', $startDate) }}">
            </div>
            <div class="revenue-field">
                <label for="tot_datum">Tot datum</label>
                <input id="tot_datum" name="tot_datum" type="date" value="{{ old('tot_datum', $endDate) }}">
            </div>
            <button class="revenue-submit" type="submit">Omzet bekijken</button>
        </form>
        <p class="revenue-meta">
            Geselecteerde periode: {{ ucfirst($periodLabel) }} ({{ \Carbon\Carbon::parse($startDate)->format('d-m-Y') }}
            t/m {{ \Carbon\Carbon::parse($endDate)->format('d-m-Y') }})
        </p>
    </section>

    <section class="revenue-summary">
        <p>Totale omzet in periode: € {{ number_format($totalRevenue, 2, ',', '.') }}</p>
    </section>

    <div class="revenue-table-wrap">
        <table class="revenue-table">
            <thead>
            <tr>
                <th>Meest geboekte reis</th>
                <th>Omzet per reis</th>
                <th>Totaal bedrag van periode</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($revenues as $revenue)
                <tr>
                    <td>{{ $revenue['meest_geboekte_reis'] }} ({{ $revenue['aantal_boekingen'] }} boekingen)</td>
                    <td>€ {{ number_format($revenue['omzet_per_reis'], 2, ',', '.') }}</td>
                    <td>€ {{ number_format($revenue['totaal_bedrag_van_periode'], 2, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">
                        <p class="revenue-empty">Er is geen omzet beschikbaar voor de geselecteerde periode.</p>
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
