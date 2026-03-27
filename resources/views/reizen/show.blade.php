<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $reis->titel }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f3f3f3;
            margin: 0;
            padding: 40px;
            color: #0d2238;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
        }

        .kaart {
            background: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        }

        .reis-afbeelding {
            width: 100%;
            max-width: 400px;
            border-radius: 12px;
            margin-bottom: 20px;
        }

        h1 {
            margin-top: 0;
        }

        .terug {
            display: inline-block;
            margin-top: 25px;
            text-decoration: none;
            color: white;
            background: #0d2238;
            padding: 12px 18px;
            border-radius: 8px;
        }

        .label {
            font-weight: bold;
        }

        .promo {
            display: inline-block;
            margin-top: 10px;
            padding: 10px 18px;
            border: 2px solid #3d8dff;
            border-radius: 999px;
            color: #0c3b67;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="kaart">
            @if($reis->afbeelding)
                <img src="{{ asset('images/' . $reis->afbeelding) }}" alt="{{ $reis->titel }}" class="reis-afbeelding">
            @endif

            <h1>{{ $reis->titel }}</h1>

            <p><span class="label">Land:</span> {{ $reis->land ?? 'Onbekend' }}</p>
            <p><span class="label">Soort reis:</span> {{ $reis->soort_reis ?? 'Retour' }}</p>
            <p><span class="label">Prijs:</span> EUR {{ number_format($reis->prijs, 2, ',', '.') }}</p>
            <p><span class="label">Beschrijving:</span> {{ $reis->beschrijving }}</p>

            @if($reis->promo)
                <div class="promo">Promo tarief</div>
            @endif

            <a href="{{ route('reizen.index') }}" class="terug">Terug naar overzicht</a>
        </div>
    </div>
</body>
</html>
