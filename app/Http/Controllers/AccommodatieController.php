<?php

namespace App\Http\Controllers;

use App\Models\Accommodatie;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class AccommodatieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $accommodaties = Accommodatie::all();
        return view('accommodaties.index', compact('accommodaties'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('accommodaties.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'naam'            => 'required|string|max:100|unique:accommodaties,naam',
            'type'            => 'required|in:Villa,Hotel,Appartement',
            'locatie'         => 'nullable|string|max:100',
            'prijs_per_nacht' => 'nullable|numeric|min:0|max:999',
        ], [
            'naam.unique'         => 'Deze accommodatie naam bestaat al. Kies een andere naam.',
            'type.required'       => 'Het type accommodatie is verplicht.',
            'type.in'             => 'Kies een geldig type (Villa, Hotel of Appartement).',
            'prijs_per_nacht.max' => 'De prijs per nacht kan maximaal €999 zijn.'
        ]);

        try {
            Accommodatie::create($validated);
            return redirect()->route('accommodaties.index')
                             ->with('status_success', 'Accommodatie is succesvol toegevoegd.');
        } catch (QueryException $e) {
            \Log::error('Fout bij het aanmaken van accommodatie: ' . $e->getMessage());
            return redirect()->back()
                             ->withInput()
                             ->with('status_error', 'Er is een fout opgetreden bij het opslaan van de accommodatie. Probeer het opnieuw.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
