<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reis extends Model
{
    protected $table = 'reizen';

    protected $fillable = [
        'titel',
        'land',
        'beschrijving',
        'prijs',
        'afbeelding',
        'soort_reis',
        'promo'
    ];
}
