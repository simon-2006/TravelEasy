<?php

namespace Database\Seeders;

use App\Models\Accommodatie;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AccommodatieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Accommodatie::create([
            'naam' => 'Hotel De Gouden Leeuw',
            'type' => 'Hotel',
            'locatie' => 'Amsterdam',
            'prijs_per_nacht' => 150.00,
            'beschrijving' => 'Een luxe hotel in het hart van Amsterdam.',
        ]);

        Accommodatie::create([
            'naam' => 'Appartement Zeezicht',
            'type' => 'Appartement',
            'locatie' => 'Zandvoort',
            'prijs_per_nacht' => 100.00,
            'beschrijving' => 'Een modern appartement met uitzicht op zee.',
        ]);

        Accommodatie::create([
            'naam' => 'B&B De Oude Boerderij',
            'type' => 'Bed & Breakfast',
            'locatie' => 'Giethoorn',
            'prijs_per_nacht' => 80.00,
            'beschrijving' => 'Een charmante B&B in het waterdorp Giethoorn.',
        ]);
    }
}
