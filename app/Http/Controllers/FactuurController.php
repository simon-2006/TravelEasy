<?php

namespace App\Http\Controllers;

use App\Models\Factuur;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class FactuurController extends Controller
{
    public function index()
    {
        $facturen = Factuur::all();
        return view('facturen.index', compact('facturen'));
    }

    public function create()
    {
        // Hier kun je eventueel boekingen ophalen om in een dropdown te tonen
        // $boekingen = \App\Models\Boeking::all();
        return view('facturen.create'); // , compact('boekingen')
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'boekingId'     => 'required|integer|exists:boekingen,Id', // Controleert of boekingId bestaat in de 'boekingen' tabel
            'totaal_bedrag' => 'required|numeric|min:0|max:99999',
            'betaald'       => 'boolean', // 0 of 1
        ], [
            'boekingId.required'     => 'Het boekingsnummer is verplicht.',
            'boekingId.exists'       => 'Het opgegeven boekingsnummer bestaat niet.',
            'totaal_bedrag.required' => 'Het totaalbedrag is verplicht.',
            'totaal_bedrag.max'      => 'Het totaalbedrag mag maximaal €99.999 zijn.',
            'betaald.boolean'        => 'De status moet waar of onwaar zijn (0 of 1).',
        ]);

        try {
            Factuur::create($validated);
            return redirect()->route('facturen.index')
                             ->with('status_success', 'Factuur is succesvol toegevoegd.');
        } catch (QueryException $e) {
            // Log de fout voor debugging
            \Log::error('Fout bij het aanmaken van factuur: ' . $e->getMessage());

            // Controleer op specifieke fouten, bijv. foreign key constraints
            if (str_contains($e->getMessage(), 'FOREIGN KEY constraint failed')) {
                return redirect()->back()
                                 ->withInput()
                                 ->with('status_error', 'Fout: Het opgegeven boekingsnummer is ongeldig of bestaat niet.');
            }
            return redirect()->back()
                             ->withInput()
                             ->with('status_error', 'Er is een onverwachte fout opgetreden bij het opslaan van de factuur. Probeer het opnieuw.');
        }
    }
}