<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class Boeking extends Model
{
    protected $table = 'boekingen';

    protected $primaryKey = 'Id';

    public $timestamps = false;

    public static function totaalAantal(): int
    {
        if (! Schema::hasTable('boekingen')) {
            return 0;
        }

        try {
            return (int) self::query()->count();
        } catch (QueryException) {
            return 0;
        }
    }

    public static function overzichtRijen(): Collection
    {
        if (! Schema::hasTable('boekingen')) {
            return collect();
        }

        try {
            $dateExpression = "DATE(b.datum_boeking)";
            $statusExpression = "COALESCE(NULLIF(b.status, ''), 'onbekend')";
            $landExpression = "'Onbekend'";

            $query = self::query()->from('boekingen as b');

            if (
                Schema::hasTable('reizen')
                && Schema::hasColumn('boekingen', 'reisId')
                && Schema::hasColumn('reizen', 'Id')
                && Schema::hasColumn('reizen', 'bestemming')
            ) {
                $query->leftJoin('reizen as r', 'r.Id', '=', 'b.reisId');
                $landExpression = "COALESCE(NULLIF(r.bestemming, ''), 'Onbekend')";
            }

            $rows = $query
                ->selectRaw("$dateExpression as boekingsdatum")
                ->selectRaw("$landExpression as land")
                ->selectRaw("$statusExpression as status")
                ->selectRaw('COUNT(*) as aantal')
                ->groupByRaw("$dateExpression, $landExpression, $statusExpression")
                ->orderByRaw("$dateExpression ASC")
                ->get();
        } catch (QueryException) {
            return collect();
        }

        $previousByKey = [];

        $mapped = $rows->map(function (object $row) use (&$previousByKey): array {
            $date = Carbon::parse($row->boekingsdatum);
            $aantal = (int) ($row->aantal ?? 0);
            $land = (string) ($row->land ?? 'Onbekend');
            $status = (string) ($row->status ?? 'onbekend');
            $key = strtolower($land.'|'.$status);
            $previousValue = $previousByKey[$key] ?? null;

            $previousByKey[$key] = $aantal;

            return [
                'datum_sort' => $date->toDateString(),
                'datum' => self::formatRelativeDate($date),
                'aantal' => $aantal,
                'land' => $land,
                'trend' => self::determineTrend($aantal, $previousValue),
                'status' => ucfirst($status),
            ];
        });

        return $mapped
            ->sortByDesc('datum_sort')
            ->values();
    }

    private static function determineTrend(int $current, ?int $previous): string
    {
        if ($previous === null) {
            return 'Nieuw';
        }

        if ($current > $previous) {
            return 'Stijgend';
        }

        if ($current < $previous) {
            return 'Dalend';
        }

        return 'Gelijk';
    }

    private static function formatRelativeDate(Carbon $date): string
    {
        if ($date->isToday()) {
            return 'Vandaag';
        }

        if ($date->isYesterday()) {
            return 'Gisteren';
        }

        if ($date->isTomorrow()) {
            return 'Morgen';
        }

        return $date->format('d-m-Y');
    }
}
