<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('klanten', function (Blueprint $table): void {
            $table->increments('Id');
            $table->unsignedBigInteger('userId')->nullable();
            $table->string('naam', 100);
            $table->string('adres', 255)->nullable();
            $table->string('telefoon', 20)->nullable();
            $table->date('geboortedatum')->nullable();
            $table->boolean('IsActief')->default(true);
            $table->string('Opmerking', 255)->nullable();
            $table->timestamp('DatumAangemaakt')->useCurrent();
            $table->timestamp('DatumGewijzigd')->useCurrent()->nullable();
        });

        // Insert fake klanten
        \DB::table('klanten')->insert([
            [
                'userId' => 1,
                'naam' => 'Jan Jansen',
                'adres' => 'Dorpsstraat 1, 1234 AB Dorp',
                'telefoon' => '0612345678',
                'geboortedatum' => '1980-01-01',
                'IsActief' => true,
                'Opmerking' => 'Goede klant',
                'DatumAangemaakt' => now(),
                'DatumGewijzigd' => now(),
            ],
            [
                'userId' => 2,
                'naam' => 'Piet Pietersen',
                'adres' => 'Laan 2, 2345 BC Stad',
                'telefoon' => '0687654321',
                'geboortedatum' => '1990-05-15',
                'IsActief' => false,
                'Opmerking' => 'Niet actief',
                'DatumAangemaakt' => now(),
                'DatumGewijzigd' => now(),
            ],
            [
                'userId' => 3,
                'naam' => 'Klaas de Vries',
                'adres' => 'Singel 3, 3456 CD Plaats',
                'telefoon' => '0678901234',
                'geboortedatum' => '1975-09-23',
                'IsActief' => true,
                'Opmerking' => 'Nieuwe klant',
                'DatumAangemaakt' => now(),
                'DatumGewijzigd' => now(),
            ],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('klanten');
    }
};
