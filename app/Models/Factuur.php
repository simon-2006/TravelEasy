<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Factuur extends Model
{
    use HasFactory;

    protected $table = 'facturen'; // Correcte tabelnaam
    protected $primaryKey = 'Id';
    public $timestamps = false; // Schakel Laravel's timestamps uit

    protected $fillable = [
        'boekingId',
        'totaal_bedrag',
        'betaald',
        // 'datum_factuur' wordt standaard door de database ingesteld
        // Voeg hier eventueel andere velden toe die je via het formulier wilt kunnen invullen
        // 'IsActief', 'Opmerking'
    ];

    // Optioneel: Relatie met Boeking model
    // public function boeking() {
    //     return $this->belongsTo(Boeking::class, 'boekingId', 'Id');
    // }
}