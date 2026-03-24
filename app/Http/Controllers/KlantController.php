<?php

namespace App\Http\Controllers;

use App\Models\Klant;
use Illuminate\Http\Request;

class KlantController extends Controller
{
    public function index()
    {
        $klanten = \DB::table('klanten')->get();
        return view('klanten.page', compact('klanten'));
    }

    public function create()
{
    return view('klanten.create');
}

    public function edit($id)
    {
        $klant = Klant::findOrFail($id);
        return view('klanten.edit', compact('klant'));
    }

    public function store(Request $request)
    {
        $data = $request->only([
            'naam', 'adres', 'telefoon', 'geboortedatum', 'IsActief', 'Opmerking'
        ]);

        $data['DatumAangemaakt'] = now();
        $data['DatumGewijzigd'] = now();

        \DB::table('klanten')->insert($data);

        return redirect()->back()->with('success', 'Klant toegevoegd.');
    }

    public function update(Request $request, $id)
    {
        $data = $request->only([
            'naam', 'adres', 'telefoon', 'geboortedatum', 'IsActief', 'Opmerking'
        ]);

        $data['DatumGewijzigd'] = now();

        \DB::table('klanten')->where('Id', $id)->update($data);

        return redirect()->back()->with('success', 'Klant bijgewerkt.');
    }

    public function destroy($id)
    {
        \DB::table('klanten')->where('Id', $id)->delete();

        return redirect()->back()->with('success', 'Klant verwijderd.');
    }
}