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
            ['titel' => 'Stedentrip Amsterdam', 'land' => 'Nederland', 'prijs' => 499.00],
            ['titel' => 'Vlucht Barcelona', 'land' => 'Spanje', 'prijs' => 849.00],
            ['titel' => 'Roadtrip Berlijn', 'land' => 'Duitsland', 'prijs' => 589.00],
            ['titel' => 'Citybreak Rome', 'land' => 'Italie', 'prijs' => 719.00],
            ['titel' => 'Nijl Cruise', 'land' => 'Egypte', 'prijs' => 1099.00],
            ['titel' => 'Beach Aruba', 'land' => 'Aruba', 'prijs' => 1299.00],
            ['titel' => 'Tokyo Explorer', 'land' => 'Japan', 'prijs' => 1599.00],
            ['titel' => 'Rio Experience', 'land' => 'Brazilie', 'prijs' => 1399.00],
            ['titel' => 'Lissabon Weekend', 'land' => 'Portugal', 'prijs' => 669.00],
            ['titel' => 'Marrakesh Tour', 'land' => 'Marokko', 'prijs' => 779.00],
        ];

        foreach ($reizen as $index => $reis) {
            DB::table('reizen')->updateOrInsert(
                ['titel' => $reis['titel']],
                [
                    'titel' => $reis['titel'],
                    'land' => $reis['land'],
                    'beschrijving' => 'Beschrijving voor ' . $reis['titel'],
                    'prijs' => $reis['prijs'],
                    'afbeelding' => null,
                    'soort_reis' => 'Retour',
                    'promo' => false,
                    'updated_at' => $now,
                    'created_at' => $now,
                ]
            );
        }

        $reisIdsByName = DB::table('reizen')
            ->whereIn('titel', collect($reizen)->pluck('titel'))
            ->pluck('id', 'titel');

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
