<?php

namespace App\Http\Controllers;

use App\Models\Transport;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\View\View;

class TransportController extends Controller
{
    public function index(): View
    {
        $transporten = Transport::all();
        return view('transport.index', compact('transporten'));
    }

    public function create()
    {
        return view('transport.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type'           => 'required|in:vliegtuig,bus,trein,boot,auto',
            'maatschappij'   => 'nullable|string|max:100',
            'vertrekplaats'  => 'nullable|string|max:100',
            'aankomstplaats' => 'nullable|string|max:100',
            'prijs'          => 'nullable|numeric|min:0|max:999',
        ], [
            'type.required'  => 'Het type transport is verplicht.',
            'type.in'        => 'Kies een geldig type transport (vliegtuig, bus, trein, boot of auto).',
            'prijs.max'      => 'De prijs mag maximaal €999 zijn.'
        ]);

        try {
            Transport::create($validated);
            return redirect()->route('transport.index')
                             ->with('status_success', 'Transport is succesvol toegevoegd.');
        } catch (QueryException $e) {
            \Log::error('Fout bij het aanmaken van transport: ' . $e->getMessage());
            return redirect()->back()
                             ->withInput()
                             ->with('status_error', 'Er is een fout opgetreden bij het opslaan van het transport. Probeer het opnieuw.');
        }
    }
}