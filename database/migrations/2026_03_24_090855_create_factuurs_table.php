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
        Schema::create('facturen', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('boeking_id');
            $table->decimal('totaal_bedrag', 8, 2);
            $table->date('factuur_datum');
            $table->date('verval_datum');
            $table->string('status');
            $table->timestamps();

            $table->foreign('boeking_id')->references('Id')->on('boekingen')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facturen');
    }
};
