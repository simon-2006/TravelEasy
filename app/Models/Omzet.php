<?php

namespace App\Models;

use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class Omzet extends Model
{
    protected $table = 'boekingen';

    protected $primaryKey = 'Id';

    public $timestamps = false;

    public static function totaalVoorOverzicht(Collection $rows): float
    {
        return (float) $rows->sum('totaal_bedrag_van_periode');
    }

    public static function overzichtVoorPeriode(CarbonImmutable $from, CarbonImmutable $to): Collection
    {
        if (! Schema::hasTable('boekingen') || ! Schema::hasTable('reizen')) {
            return collect();
        }

        if (
            ! Schema::hasColumn('boekingen', 'datum_boeking')
            || ! Schema::hasColumn('boekingen', 'aantal_personen')
            || ! Schema::hasColumn('boekingen', 'status')
            || ! Schema::hasColumn('boekingen', 'reisId')
            || ! Schema::hasColumn('reizen', 'Id')
            || ! Schema::hasColumn('reizen', 'bestemming')
            || ! Schema::hasColumn('reizen', 'prijs')
        ) {
            return collect();
        }

        try {
            $bestemmingExpression = "COALESCE(NULLIF(r.bestemming, ''), 'Onbekend')";
            $omzetExpression = 'SUM(COALESCE(r.prijs, 0) * COALESCE(NULLIF(b.aantal_personen, 0), 1))';

            $rows = self::query()
                ->from('boekingen as b')
                ->leftJoin('reizen as r', 'r.Id', '=', 'b.reisId')
                ->selectRaw("$bestemmingExpression as bestemming")
                ->selectRaw('COUNT(*) as aantal_boekingen')
                ->selectRaw("$omzetExpression as totaal_bedrag_van_periode")
                ->whereNotNull('b.datum_boeking')
                ->whereBetween(
                    DB::raw('DATE(b.datum_boeking)'),
                    [$from->toDateString(), $to->toDateString()]
                )
                ->whereRaw("LOWER(COALESCE(NULLIF(b.status, ''), 'onbekend')) <> 'geannuleerd'")
                ->groupByRaw($bestemmingExpression)
                ->orderByRaw('COUNT(*) DESC')
                ->orderByRaw("$omzetExpression DESC")
                ->get();
        } catch (QueryException) {
            return collect();
        }

        return $rows->map(function (object $row): array {
            $aantalBoekingen = (int) ($row->aantal_boekingen ?? 0);
            $totalAmount = round((float) ($row->totaal_bedrag_van_periode ?? 0), 2);
            $averagePerBooking = $aantalBoekingen > 0
                ? round($totalAmount / $aantalBoekingen, 2)
                : 0.0;

            return [
                'meest_geboekte_reis' => (string) ($row->bestemming ?? 'Onbekend'),
                'aantal_boekingen' => $aantalBoekingen,
                'omzet_per_reis' => $averagePerBooking,
                'totaal_bedrag_van_periode' => $totalAmount,
            ];
        })->values();
    }
}
