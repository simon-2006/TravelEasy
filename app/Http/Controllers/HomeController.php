<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $countryBundle = \ResourceBundle::create('nl', 'ICUDATA-region');
        $countriesBundle = $countryBundle instanceof \ResourceBundle
            ? $countryBundle->get('Countries')
            : null;
        $countries = collect();

        if ($countriesBundle instanceof \ResourceBundle) {
            foreach ($countriesBundle as $code => $name) {
                if (preg_match('/^[A-Z]{2}$/', (string) $code) !== 1) {
                    continue;
                }

                if (in_array((string) $code, ['EU', 'EZ', 'UN'], true)) {
                    continue;
                }

                $countries->push([
                    'code' => strtolower((string) $code),
                    'name' => (string) $name,
                ]);
            }
        }

        $groupedCountries = $countries
            ->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE)
            ->values()
            ->groupBy(function (array $country): string {
                $asciiName = Str::ascii($country['name']);
                $firstLetter = Str::upper(Str::substr($asciiName, 0, 1));

                return preg_match('/^[A-Z]$/', $firstLetter) === 1 ? $firstLetter : '#';
            })
            ->sortKeys()
            ->map(fn ($items) => $items->values());

        return view('welcome', [
            'groupedCountries' => $groupedCountries,
        ]);
    }
}
