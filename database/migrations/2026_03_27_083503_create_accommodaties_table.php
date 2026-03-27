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
        Schema::dropIfExists('accommodaties');
    }
};
