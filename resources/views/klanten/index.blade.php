<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Klantenoverzicht</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Klantenoverzicht</h2>
        <a href="/klanten/create" class="btn btn-success rounded-pill px-4">
            <i class="bi bi-person-plus me-1"></i> Klant toevoegen
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>Naam</th>
                        <th>Adres</th>
                        <th>Telefoon</th>
                        <th>Geboortedatum</th>
                        <th>Actief</th>
                        <th>Opmerking</th>
                        <th class="text-end">Acties</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($klanten as $klant)
                    <tr>
                        <td class="fw-semibold">{{ $klant->naam }}</td>
                        <td class="text-muted">{{ $klant->adres }}</td>
                        <td>{{ $klant->telefoon }}</td>
                        <td>{{ $klant->geboortedatum }}</td>
                        <td>
                            @if($klant->IsActief)
                                <span class="badge bg-success">Ja</span>
                            @else
                                <span class="badge bg-secondary">Nee</span>
                            @endif
                        </td>
                        <td class="text-muted">{{ $klant->Opmerking }}</td>
                        <td class="text-end">
                            <a href="/klanten/{{ $klant->Id }}/edit" class="btn btn-warning btn-sm rounded-pill text-white me-1">
                                <i class="bi bi-pencil me-1"></i> Wijzig
                            </a>
                            <form action="/klanten/{{ $klant->Id }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm rounded-pill"
                                        onclick="return confirm('Weet je zeker dat je deze klant wilt verwijderen?')">
                                    <i class="bi bi-trash me-1"></i> Verwijder
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>