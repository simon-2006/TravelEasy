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
        Schema::create('transport', function (Blueprint $table) {
            $table->id('Id');
            $table->enum('type', ['vliegtuig', 'bus', 'trein', 'boot', 'auto']);
            $table->string('maatschappij', 100)->nullable();
            $table->string('vertrekplaats', 100)->nullable();
            $table->string('aankomstplaats', 100)->nullable();
            $table->decimal('prijs', 10, 2)->nullable();
            $table->boolean('IsActief')->default(true);
            $table->string('Opmerking', 255)->nullable();
            $table->timestamp('DatumAangemaakt')->useCurrent();
            $table->timestamp('DatumGewijzigd')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transport');
    }
};
