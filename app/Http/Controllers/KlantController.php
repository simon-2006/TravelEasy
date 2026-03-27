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
        // Valideer de invoer om dubbele klanten te voorkomen
        $request->validate([
            'naam' => 'required|string|max:100|unique:klanten,naam', // Uniek op naam
            'adres' => 'nullable|string|max:255',
            'telefoon' => 'nullable|string|max:20',
            'geboortedatum' => 'nullable|date',
            'IsActief' => 'nullable|boolean',
            'Opmerking' => 'nullable|string|max:255',
        ], [
            'naam.required' => 'De naam van de klant is verplicht.',
            'naam.unique' => 'Deze klant naam bestaat al. Kies een andere naam.',
            'adres.max' => 'Het adres mag maximaal 255 karakters bevatten.',
            'telefoon.max' => 'Het telefoonnummer mag maximaal 20 karakters bevatten.',
            'geboortedatum.date' => 'Voer een geldige geboortedatum in.',
            'Opmerking.max' => 'De opmerking mag maximaal 255 karakters bevatten.',
        ]);

        // Bereid de data voor om in te voegen
        $data = $request->only([
            'naam', 'adres', 'telefoon', 'geboortedatum', 'IsActief', 'Opmerking'
        ]);

        // Stel de datums in
        $data['DatumAangemaakt'] = now();
        $data['DatumGewijzigd'] = now();

        try {
            // Voeg de klant toe aan de database
            \DB::table('klanten')->insert($data);

            // Redirect naar de index pagina met succesbericht
            return redirect()->route('klanten.index')->with('success', 'Klant is succesvol toegevoegd.');
        } catch (\Exception $e) {
            // Bij fout, redirect terug met foutmelding
            return redirect()->back()->with('error', 'Er is een fout opgetreden bij het toevoegen van de klant.');
        }
    }

    public function update(Request $request, $id)
    {
        // Haal de huidige data op
        $currentData = \DB::table('klanten')->where('Id', $id)->first();
        if (!$currentData) {
            return redirect()->route('klanten.index')->with('error', 'Klant niet gevonden.');
        }

        $data = $request->only([
            'naam', 'adres', 'telefoon', 'geboortedatum', 'IsActief', 'Opmerking'
        ]);

        // Controleer of er wijzigingen zijn
        $hasChanges = false;
        foreach ($data as $key => $value) {
            if ($currentData->$key != $value) {
                $hasChanges = true;
                break;
            }
        }

        if (!$hasChanges) {
            return redirect()->back()->with('info', 'Er is niks gewijzigd omdat er geen wijzigingen zijn gemaakt.');
        }

        $data['DatumGewijzigd'] = now();

        try {
            \DB::table('klanten')->where('Id', $id)->update($data);

            return redirect()->route('klanten.index')->with('success', 'Klant is succesvol bijgewerkt.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Er is een fout opgetreden bij het bijwerken van de klant.');
        }
    }

    public function destroy($id)
    {
        // Controleer of de klant bestaat
        $klant = \DB::table('klanten')->where('Id', $id)->first();
        if (!$klant) {
            return redirect()->route('klanten.index')->with('info', 'Klant is al verwijderd.');
        }

        try {
            \DB::table('klanten')->where('Id', $id)->delete();

            return redirect()->route('klanten.index')->with('success', 'Klant is succesvol verwijderd.');
        } catch (\Exception $e) {
            return redirect()->route('klanten.index')->with('error', 'Er is een fout opgetreden bij het verwijderen van de klant.');
        }
    }
}