<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Klanten</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5" style="max-width: 600px">

    <h2 class="mb-4">Klant toevoegen</h2>

    {{-- Fouten tonen --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body p-4">
            <form method="POST" action="/klanten">
                @csrf

                <div class="row g-3 mb-3">
                    <div class="col-sm-6">
                        <label class="form-label">Naam <span class="text-danger">*</span></label>
                        <input type="text" name="naam" class="form-control" placeholder="Volledige naam" required>
                    </div>
                    <div class="col-sm-6">
                        <label class="form-label">Telefoon</label>
                        <input type="text" name="telefoon" class="form-control" placeholder="+31 6 00 00 00 00">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Adres</label>
                    <input type="text" name="adres" class="form-control" placeholder="Straat, huisnummer, woonplaats">
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-sm-6">
                        <label class="form-label">Geboortedatum</label>
                        <input type="date" name="geboortedatum" class="form-control">
                    </div>
                    <div class="col-sm-6">
                        <label class="form-label">Actief</label>
                        <select name="IsActief" class="form-select">
                            <option value="1">Ja</option>
                            <option value="0">Nee</option>
                        </select>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label">Opmerking</label>
                    <textarea name="Opmerking" class="form-control" rows="3" placeholder="Eventuele opmerkingen..."></textarea>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="/klanten" class="btn btn-outline-secondary">Terug</a>
                    <button type="submit" class="btn btn-success">Opslaan</button>
                </div>

            </form>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>