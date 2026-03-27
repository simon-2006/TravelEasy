@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Facturenoverzicht</h1>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Boeking ID</th>
                <th>Datum Factuur</th>
                <th>Totaal Bedrag</th>
                <th>Betaald</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($facturen as $factuur)
            <tr>
                <td>{{ $factuur->id }}</td>
                <td>{{ $factuur->boeking_id ?? $factuur->boekingId }}</td>
                <td>{{ \Carbon\Carbon::parse($factuur->datum_factuur)->format('d-m-Y H:i') }}</td>
                <td>&euro; {{ number_format($factuur->totaal_bedrag, 2, ',', '.') }}</td>
                <td>
                    <span class="badge {{ $factuur->betaald ? 'bg-success' : 'bg-danger' }}">
                        {{ $factuur->betaald ? 'Ja' : 'Nee' }}
                    </span>
                </td>
                <td>{{ $factuur->IsActief ? 'Actief' : 'Inactief' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6">Er zijn momenteel geen facturen beschikbaar.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection