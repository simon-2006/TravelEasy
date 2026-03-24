<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reis toevoegen</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f3f3f3;
            margin: 0;
            padding: 40px;
            color: #0d2238;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
        }

        .kaart {
            background: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        }

        h1 {
            margin-top: 0;
        }

        .veld {
            margin-bottom: 18px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="number"],
        textarea,
        select {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-sizing: border-box;
            font-size: 16px;
        }

        textarea {
            min-height: 120px;
            resize: vertical;
        }

        .checkbox-veld {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .knoppen {
            margin-top: 25px;
            display: flex;
            gap: 12px;
        }

        .btn {
            display: inline-block;
            text-decoration: none;
            padding: 12px 18px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }

        .btn-opslaan {
            background: #0d2238;
            color: white;
        }

        .btn-terug {
            background: #d9d9d9;
            color: #0d2238;
        }

        .fouten {
            background: #ffe3e3;
            color: #9b1c1c;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .fouten ul {
            margin: 0;
            padding-left: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="kaart">
            <h1>Reis toevoegen</h1>

            @if($errors->any())
                <div class="fouten">
                    <ul>
                        @foreach($errors->all() as $fout)
                            <li>{{ $fout }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('reizen.store') }}" method="POST">
                @csrf

                <div class="veld">
                    <label for="titel">Titel</label>
                    <input type="text" id="titel" name="titel" value="{{ old('titel') }}" required>
                </div>

                <div class="veld">
                    <label for="land">Land</label>
                    <input type="text" id="land" name="land" value="{{ old('land') }}">
                </div>

                <div class="veld">
                    <label for="beschrijving">Beschrijving</label>
                    <textarea id="beschrijving" name="beschrijving" required>{{ old('beschrijving') }}</textarea>
                </div>

                <div class="veld">
                    <label for="prijs">Prijs</label>
                    <input type="number" id="prijs" name="prijs" step="0.01" value="{{ old('prijs') }}" required>
                </div>

                <div class="veld">
                    <label for="soort_reis">Soort reis</label>
                    <select id="soort_reis" name="soort_reis" required>
                        <option value="Retour" {{ old('soort_reis') == 'Retour' ? 'selected' : '' }}>Retour</option>
                        <option value="Enkele reis" {{ old('soort_reis') == 'Enkele reis' ? 'selected' : '' }}>Enkele reis</option>
                    </select>
                </div>

                <div class="veld">
                    <label for="afbeelding">Afbeelding bestandsnaam</label>
                    <input type="text" id="afbeelding" name="afbeelding" value="{{ old('afbeelding') }}" placeholder="bijvoorbeeld mexico.jpg">
                </div>

                <div class="veld checkbox-veld">
                    <input type="checkbox" id="promo" name="promo" value="1" {{ old('promo') ? 'checked' : '' }}>
                    <label for="promo" style="margin: 0;">Promo tarief</label>
                </div>

                <div class="knoppen">
                    <button type="submit" class="btn btn-opslaan">Reis opslaan</button>
                    <a href="{{ route('reizen.index') }}" class="btn btn-terug">Terug</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
