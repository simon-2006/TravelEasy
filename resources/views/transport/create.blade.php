<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TravelEasy | Nieuw Transport</title>
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
            margin-bottom: 1.5rem;
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

        .transport-form-wrap {
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

        .transport-submit {
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

        .transport-submit:hover {
            filter: brightness(1.05);
        }
    </style>
</head>
<body>
<div class="transport-shell">
    <div class="transport-head">
        <h1>Nieuw Transport Toevoegen</h1>
        <a class="transport-back" href="{{ route('transport.index') }}">Terug naar overzicht</a>
    </div>

    @include('partials.flash')

    <div class="transport-form-wrap">
        <form action="{{ route('transport.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label class="form-label" for="type">Type *</label>
                <select name="type" id="type" required class="form-control">
                    <option value="">Kies een type...</option>
                    <option value="vliegtuig" {{ old('type') == 'vliegtuig' ? 'selected' : '' }}>Vliegtuig</option>
                    <option value="bus" {{ old('type') == 'bus' ? 'selected' : '' }}>Bus</option>
                    <option value="trein" {{ old('type') == 'trein' ? 'selected' : '' }}>Trein</option>
                    <option value="boot" {{ old('type') == 'boot' ? 'selected' : '' }}>Boot</option>
                    <option value="auto" {{ old('type') == 'auto' ? 'selected' : '' }}>Auto</option>
                </select>
                @error('type') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="maatschappij">Maatschappij</label>
                <input type="text" name="maatschappij" id="maatschappij" value="{{ old('maatschappij') }}" class="form-control">
            </div>

            <div class="form-group">
                <label class="form-label" for="vertrekplaats">Vertrekplaats</label>
                <input type="text" name="vertrekplaats" id="vertrekplaats" value="{{ old('vertrekplaats') }}" class="form-control">
            </div>

            <div class="form-group">
                <label class="form-label" for="aankomstplaats">Aankomstplaats</label>
                <input type="text" name="aankomstplaats" id="aankomstplaats" value="{{ old('aankomstplaats') }}" class="form-control">
            </div>

            <div class="form-group">
                <label class="form-label" for="prijs">Prijs (&euro;)</label>
                <input type="number" step="0.01" max="999" name="prijs" id="prijs" value="{{ old('prijs') }}" class="form-control">
                @error('prijs') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <button type="submit" class="transport-submit">Opslaan</button>
        </form>
    </div>
</div>
</body>
</html>
