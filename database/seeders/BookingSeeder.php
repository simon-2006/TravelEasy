<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookingSeeder extends Seeder
{
    public function run(): void
    {
        if (DB::table('reizen')->count() === 0) {
            DB::table('reizen')->insert([
                [
                    'naam' => 'Stedentrip Amsterdam',
                    'bestemming' => 'Nederland',
                    'startdatum' => now()->addDays(7)->toDateString(),
                    'einddatum' => now()->addDays(10)->toDateString(),
                    'prijs' => 499.00,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'naam' => 'Weekend Parijs',
                    'bestemming' => 'Frankrijk',
                    'startdatum' => now()->addDays(12)->toDateString(),
                    'einddatum' => now()->addDays(15)->toDateString(),
                    'prijs' => 699.00,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'naam' => 'Vlucht Barcelona',
                    'bestemming' => 'Spanje',
                    'startdatum' => now()->addDays(20)->toDateString(),
                    'einddatum' => now()->addDays(25)->toDateString(),
                    'prijs' => 849.00,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);
        }

        if (DB::table('boekingen')->count() > 0) {
            return;
        }

        $reisIds = DB::table('reizen')->orderBy('Id')->pluck('Id')->values();

        if ($reisIds->count() < 3) {
            return;
        }

        DB::table('boekingen')->insert([
            [
                'reisId' => $reisIds[0],
                'aantal_personen' => 2,
                'datum_boeking' => Carbon::today()->toDateTimeString(),
                'status' => 'geboekt',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'reisId' => $reisIds[1],
                'aantal_personen' => 1,
                'datum_boeking' => Carbon::today()->toDateTimeString(),
                'status' => 'bevestigd',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'reisId' => $reisIds[2],
                'aantal_personen' => 3,
                'datum_boeking' => Carbon::yesterday()->toDateTimeString(),
                'status' => 'optie',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'reisId' => $reisIds[0],
                'aantal_personen' => 4,
                'datum_boeking' => Carbon::yesterday()->subDay()->toDateTimeString(),
                'status' => 'geannuleerd',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'reisId' => $reisIds[1],
                'aantal_personen' => 2,
                'datum_boeking' => Carbon::tomorrow()->toDateTimeString(),
                'status' => 'geboekt',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
