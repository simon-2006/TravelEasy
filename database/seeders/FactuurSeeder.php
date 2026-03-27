<?php

namespace Database\Seeders;

use App\Models\Boeking;
use App\Models\Factuur;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FactuurSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $boekingIds = Boeking::query()->limit(3)->pluck('Id');

        if ($boekingIds->count() < 3) {
            return;
        }

        Factuur::create([
            'boeking_id' => $boekingIds[0],
            'totaal_bedrag' => 998.00,
            'factuur_datum' => now()->toDateString(),
            'verval_datum' => now()->addDays(14)->toDateString(),
            'status' => 'onbetaald',
        ]);

        Factuur::create([
            'boeking_id' => $boekingIds[1],
            'totaal_bedrag' => 699.00,
            'factuur_datum' => now()->subDays(5)->toDateString(),
            'verval_datum' => now()->addDays(9)->toDateString(),
            'status' => 'betaald',
        ]);

        Factuur::create([
            'boeking_id' => $boekingIds[2],
            'totaal_bedrag' => 2547.00,
            'factuur_datum' => now()->subDays(10)->toDateString(),
            'verval_datum' => now()->subDays(4)->toDateString(),
            'status' => 'verlopen',
        ]);
    }
}
