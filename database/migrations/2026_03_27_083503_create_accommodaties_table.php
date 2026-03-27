<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Deze migratie was dubbel aanwezig in het project.
        // Als de tabel al bestaat, slaan we deze stap bewust over.
        if (Schema::hasTable('accommodaties')) {
            return;
        }

        Schema::create('accommodaties', function (Blueprint $table) {
            $table->id('Id');
            $table->string('naam');
            $table->string('locatie')->nullable();
            $table->string('type')->nullable();
            $table->decimal('prijs_per_nacht', 8, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Geen drop hier: de "echte" create-migratie is 2026_03_24_084844.
    }
};
