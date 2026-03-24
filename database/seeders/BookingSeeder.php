<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookingSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        $reizen = [
            ['naam' => 'Stedentrip Amsterdam', 'bestemming' => 'Nederland', 'prijs' => 499.00],
            ['naam' => 'Vlucht Barcelona', 'bestemming' => 'Spanje', 'prijs' => 849.00],
            ['naam' => 'Roadtrip Berlijn', 'bestemming' => 'Duitsland', 'prijs' => 589.00],
            ['naam' => 'Citybreak Rome', 'bestemming' => 'Italie', 'prijs' => 719.00],
            ['naam' => 'Nijl Cruise', 'bestemming' => 'Egypte', 'prijs' => 1099.00],
            ['naam' => 'Beach Aruba', 'bestemming' => 'Aruba', 'prijs' => 1299.00],
            ['naam' => 'Tokyo Explorer', 'bestemming' => 'Japan', 'prijs' => 1599.00],
            ['naam' => 'Rio Experience', 'bestemming' => 'Brazilie', 'prijs' => 1399.00],
            ['naam' => 'Lissabon Weekend', 'bestemming' => 'Portugal', 'prijs' => 669.00],
            ['naam' => 'Marrakesh Tour', 'bestemming' => 'Marokko', 'prijs' => 779.00],
        ];

        foreach ($reizen as $index => $reis) {
            $startdatum = $now->copy()->addDays(7 + ($index * 2))->toDateString();
            $einddatum = $now->copy()->addDays(10 + ($index * 2))->toDateString();

            DB::table('reizen')->updateOrInsert(
                ['naam' => $reis['naam']],
                [
                    'bestemming' => $reis['bestemming'],
                    'startdatum' => $startdatum,
                    'einddatum' => $einddatum,
                    'prijs' => $reis['prijs'],
                    'updated_at' => $now,
                    'created_at' => $now,
                ]
            );
        }

        $reisIdsByName = DB::table('reizen')
            ->whereIn('naam', collect($reizen)->pluck('naam'))
            ->pluck('Id', 'naam');

        if ($reisIdsByName->count() < count($reizen)) {
            return;
        }

        $today = Carbon::today();
        $weekStart = $today->copy()->startOfWeek();
        $weekEnd = $today->copy()->endOfWeek();
        $monthStart = $today->copy()->startOfMonth();
        $monthEnd = $today->copy()->endOfMonth();
        $quarterStart = $today->copy()->startOfQuarter();
        $quarterEnd = $today->copy()->endOfQuarter();
        $yearStart = $today->copy()->startOfYear();
        $yearEnd = $today->copy()->endOfYear();

        $monthOnlyDate = $this->pickDateInRangeExcluding($monthStart, $monthEnd, $weekStart, $weekEnd);
        $quarterOnlyDate = $this->pickDateInRangeExcluding($quarterStart, $quarterEnd, $monthStart, $monthEnd);
        $yearOnlyDate = $this->pickDateInRangeExcluding($yearStart, $yearEnd, $quarterStart, $quarterEnd);

        $bookingRows = [
            // Deze week
            ['reis' => 'Stedentrip Amsterdam', 'aantal' => 2, 'status' => 'geboekt', 'datum' => $weekStart->copy()->addDay()],
            ['reis' => 'Vlucht Barcelona', 'aantal' => 1, 'status' => 'bevestigd', 'datum' => $weekStart->copy()->addDays(2)],
            ['reis' => 'Roadtrip Berlijn', 'aantal' => 3, 'status' => 'geboekt', 'datum' => $weekStart->copy()->addDays(3)],
            ['reis' => 'Citybreak Rome', 'aantal' => 2, 'status' => 'optie', 'datum' => $weekEnd->copy()->subDays(2)],
            ['reis' => 'Nijl Cruise', 'aantal' => 1, 'status' => 'geboekt', 'datum' => $weekEnd->copy()->subDay()],
            ['reis' => 'Beach Aruba', 'aantal' => 2, 'status' => 'bevestigd', 'datum' => $today->copy()],

            // In deze maand, buiten deze week
            ['reis' => 'Stedentrip Amsterdam', 'aantal' => 1, 'status' => 'geboekt', 'datum' => $monthOnlyDate->copy()],
            ['reis' => 'Vlucht Barcelona', 'aantal' => 2, 'status' => 'geboekt', 'datum' => $monthOnlyDate->copy()->addDay()],
            ['reis' => 'Lissabon Weekend', 'aantal' => 2, 'status' => 'bevestigd', 'datum' => $monthOnlyDate->copy()->addDays(2)],
            ['reis' => 'Marrakesh Tour', 'aantal' => 1, 'status' => 'optie', 'datum' => $monthOnlyDate->copy()->addDays(3)],
            ['reis' => 'Citybreak Rome', 'aantal' => 2, 'status' => 'geannuleerd', 'datum' => $monthOnlyDate->copy()->addDays(4)],

            // In dit kwartaal, buiten deze maand
            ['reis' => 'Roadtrip Berlijn', 'aantal' => 2, 'status' => 'geboekt', 'datum' => $quarterOnlyDate->copy()],
            ['reis' => 'Citybreak Rome', 'aantal' => 3, 'status' => 'bevestigd', 'datum' => $quarterOnlyDate->copy()->addDay()],
            ['reis' => 'Beach Aruba', 'aantal' => 1, 'status' => 'geboekt', 'datum' => $quarterOnlyDate->copy()->addDays(2)],
            ['reis' => 'Nijl Cruise', 'aantal' => 2, 'status' => 'optie', 'datum' => $quarterOnlyDate->copy()->addDays(3)],
            ['reis' => 'Tokyo Explorer', 'aantal' => 1, 'status' => 'geboekt', 'datum' => $quarterOnlyDate->copy()->addDays(4)],

            // In dit jaar, buiten dit kwartaal
            ['reis' => 'Tokyo Explorer', 'aantal' => 4, 'status' => 'geboekt', 'datum' => $yearOnlyDate->copy()],
            ['reis' => 'Rio Experience', 'aantal' => 3, 'status' => 'bevestigd', 'datum' => $yearOnlyDate->copy()->addDay()],
            ['reis' => 'Beach Aruba', 'aantal' => 2, 'status' => 'optie', 'datum' => $yearOnlyDate->copy()->addDays(2)],
            ['reis' => 'Marrakesh Tour', 'aantal' => 2, 'status' => 'geboekt', 'datum' => $yearOnlyDate->copy()->addDays(3)],
            ['reis' => 'Lissabon Weekend', 'aantal' => 1, 'status' => 'bevestigd', 'datum' => $yearOnlyDate->copy()->addDays(4)],
        ];

        foreach ($bookingRows as $row) {
            $reisId = $reisIdsByName[$row['reis']] ?? null;

            if (! $reisId) {
                continue;
            }

            /** @var Carbon $datum */
            $datum = $row['datum']->copy()->setTime(10, 0, 0);

            $this->upsertBoeking(
                reisId: (int) $reisId,
                aantalPersonen: (int) $row['aantal'],
                status: (string) $row['status'],
                datumBoeking: $datum
            );
        }
    }

    private function pickDateInRangeExcluding(
        Carbon $rangeStart,
        Carbon $rangeEnd,
        Carbon $excludeStart,
        Carbon $excludeEnd
    ): Carbon {
        $cursor = $rangeStart->copy()->startOfDay();
        $last = $rangeEnd->copy()->startOfDay();

        while ($cursor->lte($last)) {
            if ($cursor->lt($excludeStart) || $cursor->gt($excludeEnd)) {
                return $cursor->copy();
            }

            $cursor->addDay();
        }

        return $rangeEnd->copy()->startOfDay();
    }

    private function upsertBoeking(int $reisId, int $aantalPersonen, string $status, Carbon $datumBoeking): void
    {
        DB::table('boekingen')->updateOrInsert(
            [
                'reisId' => $reisId,
                'datum_boeking' => $datumBoeking->toDateTimeString(),
                'status' => $status,
                'aantal_personen' => $aantalPersonen,
            ],
            [
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );
    }
}
