<?php

namespace App\Http\Controllers;

use App\Models\Reis;
use Illuminate\Http\Request;

class ReisController extends Controller
{
    public function index()
    {
        $reizen = Reis::orderBy('id', 'desc')->get();
        return view('reizen.index', compact('reizen'));
    }

    public function create()
    {
        return view('reizen.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'titel' => 'required|string|max:255',
            'land' => 'nullable|string|max:255',
            'beschrijving' => 'required|string',
            'prijs' => 'required|numeric|min:0',
            'soort_reis' => 'required|string|max:255',
            'promo' => 'nullable',
            'afbeelding' => 'nullable|string|max:255',
        ]);

        try {
             throw new \Exception('Database fout');

            Reis::create([
                'titel' => $request->titel,
                'land' => $request->land,
                'beschrijving' => $request->beschrijving,
                'prijs' => $request->prijs,
                'soort_reis' => $request->soort_reis,
                'promo' => $request->has('promo'),
                'afbeelding' => $request->afbeelding,
            ]);

            return redirect()->route('reizen.index')
                ->with('success', 'Reis succesvol toegevoegd.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'De reis kon niet worden opgeslagen door een databasefout.');
        }
    }

    public function show($id)
    {
        $reis = Reis::find($id);

        if (!$reis) {
            return redirect()->route('reizen.index')
                ->with('error', 'Reis niet gevonden');
        }

        return view('reizen.show', compact('reis'));
    }
}
