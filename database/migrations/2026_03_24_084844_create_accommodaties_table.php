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
        Schema::create('accommodaties', function (Blueprint $table) {
            $table->id('Id');
            $table->string('naam', 100);
            $table->string('locatie', 100)->nullable();
            $table->string('type', 50)->nullable();
            $table->decimal('prijs_per_nacht', 10, 2)->nullable();
            $table->date('check_in')->nullable();
            $table->date('check_out')->nullable();
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
        Schema::dropIfExists('accommodaties');
    }
};
