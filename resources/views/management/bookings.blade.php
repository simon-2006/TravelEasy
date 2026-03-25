<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TravelEasy | Aantal Boeking Bekijken</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow:wght@400;500;600;700&family=Space+Grotesk:wght@500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
    <style>
        .bookings-shell {
            width: min(100% - 2rem, 1120px);
            margin: 1.2rem auto 2rem;
        }

        .bookings-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            flex-wrap: wrap;
            margin-bottom: 0.9rem;
        }

        .bookings-head h1 {
            margin: 0;
            font-family: 'Space Grotesk', sans-serif;
            color: #173f66;
            font-size: 1.7rem;
        }

        .bookings-actions {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .bookings-link {
            text-decoration: none;
            color: #1f578a;
            font-weight: 700;
            border: 1px solid #c5daf0;
            border-radius: 999px;
            padding: 0.5rem 0.8rem;
            background: #f4f9ff;
        }

        .bookings-link:hover {
            background: #e8f3ff;
        }

        .bookings-summary {
            border: 1px solid #d3e2f3;
            border-radius: 14px;
            background: #ffffff;
            padding: 0.8rem 1rem;
            box-shadow: 0 16px 32px rgba(9, 42, 77, 0.1);
            margin-bottom: 0.9rem;
        }

        .bookings-summary p {
            margin: 0;
            font-weight: 700;
            color: #194a77;
        }

        .bookings-table-wrap {
            border: 1px solid #d3e2f3;
            border-radius: 14px;
            overflow: auto;
            background: #ffffff;
            box-shadow: 0 18px 35px rgba(9, 42, 77, 0.1);
        }

        .bookings-table {
            width: 100%;
            border-collapse: collapse;
            min-width: 760px;
        }

        .bookings-table th,
        .bookings-table td {
            text-align: left;
            padding: 0.75rem 0.9rem;
            border-bottom: 1px solid #e2ebf7;
            font-size: 0.95rem;
        }

        .bookings-table th {
            color: #23517d;
            background: #eff6ff;
            font-family: 'Space Grotesk', sans-serif;
            font-size: 0.93rem;
        }

        .bookings-table tr:last-child td {
            border-bottom: 0;
        }

        .status-pill {
            display: inline-block;
            border-radius: 999px;
            border: 1px solid #c8dff6;
            padding: 0.26rem 0.56rem;
            font-size: 0.8rem;
            font-weight: 700;
            color: #1c4f7c;
            background: #f4f9ff;
        }

        .trend-badge {
            display: inline-block;
            border-radius: 999px;
            border: 1px solid #c9ddd7;
            padding: 0.24rem 0.56rem;
            font-size: 0.8rem;
            font-weight: 700;
            color: #21654f;
            background: #eaf8f1;
        }
    </style>
</head>
<body>
<div class="bookings-shell">
    <div class="bookings-head">
        <h1>Aantal Boeking Bekijken</h1>
        <div class="bookings-actions">
            <a class="bookings-link" href="{{ route('management.index') }}">Dashboard beheren</a>
            @if (auth()->user()?->canViewAccountOverview())
                <a class="bookings-link" href="{{ route('accounts.index') }}">Accountoverzicht</a>
            @else
                <a class="bookings-link" href="{{ route('home') }}">Home</a>
            @endif
        </div>
    </div>

    @include('partials.flash')

    <section class="bookings-summary">
        <p>Totaal boekingen: {{ $totalBookings }}</p>
    </section>

    <div class="bookings-table-wrap">
        <table class="bookings-table">
            <thead>
            <tr>
                <th>Datum</th>
                <th>Hoeveelboeking</th>
                <th>Land</th>
                <th>Trend</th>
                <th>Status</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($bookings as $booking)
                <tr>
                    <td>{{ $booking['datum'] }}</td>
                    <td>{{ $booking['aantal'] }}</td>
                    <td>{{ $booking['land'] }}</td>
                    <td><span class="trend-badge">{{ $booking['trend'] }}</span></td>
                    <td><span class="status-pill">{{ $booking['status'] }}</span></td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">Er zijn momenteel geen boekingen beschikbaar.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
