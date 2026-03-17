<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TravelEasy | Accountoverzicht</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow:wght@400;500;600;700&family=Space+Grotesk:wght@500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
    <style>
        .accounts-shell {
            width: min(100% - 2rem, 1080px);
            margin: 1.2rem auto 2rem;
        }

        .accounts-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            margin-bottom: 0.9rem;
            flex-wrap: wrap;
        }

        .accounts-head h1 {
            margin: 0;
            font-family: 'Space Grotesk', sans-serif;
            font-size: 1.7rem;
            color: #173f66;
        }

        .accounts-back {
            text-decoration: none;
            color: #1f578a;
            font-weight: 700;
        }

        .accounts-back:hover {
            text-decoration: underline;
            text-underline-offset: 2px;
        }

        .accounts-actions {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            flex-wrap: wrap;
        }

        .accounts-manage {
            text-decoration: none;
            border-radius: 999px;
            border: 0;
            padding: 0.52rem 0.9rem;
            color: #ffffff;
            font-weight: 700;
            background: linear-gradient(160deg, #0f67d8, #0b4da7);
        }

        .accounts-manage:hover {
            filter: brightness(1.05);
        }

        .accounts-table-wrap {
            border: 1px solid #d3e2f3;
            border-radius: 14px;
            overflow: auto;
            background: #ffffff;
            box-shadow: 0 18px 35px rgba(9, 42, 77, 0.1);
        }

        .accounts-table {
            width: 100%;
            border-collapse: collapse;
            min-width: 760px;
        }

        .accounts-table th,
        .accounts-table td {
            text-align: left;
            padding: 0.75rem 0.9rem;
            border-bottom: 1px solid #e2ebf7;
            font-size: 0.95rem;
        }

        .accounts-table th {
            color: #23517d;
            background: #eff6ff;
            font-family: 'Space Grotesk', sans-serif;
            font-size: 0.93rem;
        }

        .accounts-table tr:last-child td {
            border-bottom: 0;
        }

        .role-pill {
            display: inline-block;
            border-radius: 999px;
            border: 1px solid #c8dff6;
            padding: 0.26rem 0.56rem;
            font-size: 0.8rem;
            font-weight: 700;
            color: #1c4f7c;
            background: #f4f9ff;
        }
    </style>
</head>
<body>
<div class="accounts-shell">
    <div class="accounts-head">
        <h1>Accountoverzicht</h1>
        <div class="accounts-actions">
            @if (auth()->user()?->canManageDashboard())
                <a class="accounts-manage" href="{{ route('management.index') }}">Dashboard beheren</a>
            @endif
            <a class="accounts-back" href="{{ route('home') }}">Terug naar home</a>
        </div>
    </div>

    @include('partials.flash')

    <div class="accounts-table-wrap">
        <table class="accounts-table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Naam</th>
                <th>E-mail</th>
                <th>Rol</th>
                <th>Aangemaakt op</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td><span class="role-pill">{{ $user->role }}</span></td>
                    <td>{{ $user->created_at?->format('d-m-Y H:i') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">Geen accounts gevonden.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
