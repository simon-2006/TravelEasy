<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class Account extends Model
{
    protected $table = 'users';

    protected $fillable = [
        'name',
        'email',
        'role',
        'password',
    ];

    public static function overzichtLijst(): Collection
    {
        return self::query()
            ->orderBy('name')
            ->get(['id', 'name', 'email', 'role', 'created_at']);
    }

    public static function voegToeMetMedewerker(array $attributes): object
    {
        return DB::transaction(function () use ($attributes): object {
            $user = User::create([
                'name' => $attributes['name'],
                'email' => $attributes['email'],
                'role' => $attributes['role'],
                'password' => $attributes['password'],
            ]);

            Medewerker::create([
                'user_id' => $user->id,
                'naam' => $user->name,
                'functie' => $attributes['functie'],
                'telefoon' => $attributes['telefoon'] ?? null,
                'is_actief' => true,
                'opmerking' => 'Automatisch aangemaakt tijdens account-registratie.',
            ]);

            // Onderdeel voor je opdracht: expliciete INNER JOIN tussen users en medewerkers.
            return self::query()
                ->from('users as u')
                ->join('medewerkers as m', 'm.user_id', '=', 'u.id')
                ->where('u.id', $user->id)
                ->select([
                    'u.id',
                    'u.name',
                    'u.email',
                    'u.role',
                    'u.created_at',
                    'm.functie',
                ])
                ->firstOrFail();
        });
    }
}
