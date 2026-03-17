<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('boekingen', function (Blueprint $table): void {
            $table->increments('Id');
            $table->unsignedInteger('reisId')->nullable();
            $table->integer('aantal_personen')->default(1);
            $table->dateTime('datum_boeking')->nullable();
            $table->string('status', 50)->default('optie');
            $table->timestamps();

            $table->foreign('reisId')
                ->references('Id')
                ->on('reizen')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('boekingen');
    }
};
