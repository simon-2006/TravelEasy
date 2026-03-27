<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TravelEasy | Nieuwe Accommodatie</title>
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
            margin-bottom: 1.5rem;
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

        .accommodaties-form-wrap {
            border: 1px solid #d3e2f3;
            border-radius: 14px;
            background: #ffffff;
            box-shadow: 0 18px 35px rgba(9, 42, 77, 0.1);
            padding: 2rem;
            max-width: 600px;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            color: #23517d;
            font-weight: 600;
            font-size: 0.95rem;
        }

        .form-control {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid #d3e2f3;
            border-radius: 8px;
            font-family: inherit;
            font-size: 0.95rem;
            color: #173f66;
            box-sizing: border-box;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .form-control:focus {
            outline: none;
            border-color: #0f67d8;
            box-shadow: 0 0 0 3px rgba(15, 103, 216, 0.1);
        }

        .text-danger {
            color: #b91c1c;
            font-size: 0.85rem;
            margin-top: 0.4rem;
            display: block;
        }

        .accommodaties-submit {
            text-decoration: none;
            border-radius: 999px;
            border: 0;
            padding: 0.6rem 1.2rem;
            color: #ffffff;
            font-weight: 700;
            background: linear-gradient(160deg, #0f67d8, #0b4da7);
            cursor: pointer;
            font-family: inherit;
            font-size: 1rem;
        }

        .accommodaties-submit:hover {
            filter: brightness(1.05);
        }
    </style>
</head>
<body>
<div class="accommodaties-shell">
    <div class="accommodaties-head">
        <h1>Nieuwe Accommodatie Toevoegen</h1>
        <a class="accommodaties-back" href="{{ route('accommodaties.index') }}">Terug naar overzicht</a>
    </div>

    @include('partials.flash')

    <div class="accommodaties-form-wrap">
        <form action="{{ route('accommodaties.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label class="form-label" for="naam">Naam *</label>
                <input type="text" name="naam" id="naam" value="{{ old('naam') }}" required class="form-control">
                @error('naam') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="type">Type *</label>
                <select name="type" id="type" required class="form-control">
                    <option value="">Kies een type...</option>
                    <option value="Villa" {{ old('type') == 'Villa' ? 'selected' : '' }}>Villa</option>
                    <option value="Hotel" {{ old('type') == 'Hotel' ? 'selected' : '' }}>Hotel</option>
                    <option value="Appartement" {{ old('type') == 'Appartement' ? 'selected' : '' }}>Appartement</option>
                </select>
                @error('type') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="locatie">Locatie</label>
                <input type="text" name="locatie" id="locatie" value="{{ old('locatie') }}" class="form-control">
            </div>

            <div class="form-group">
                <label class="form-label" for="prijs_per_nacht">Prijs per nacht (&euro;)</label>
                <input type="number" step="0.01" max="999" name="prijs_per_nacht" id="prijs_per_nacht" value="{{ old('prijs_per_nacht') }}" class="form-control">
                @error('prijs_per_nacht') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <button type="submit" class="accommodaties-submit">Opslaan</button>
        </form>
    </div>
</div>
</body>
</html>