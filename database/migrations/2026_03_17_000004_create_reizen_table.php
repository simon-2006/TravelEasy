<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reizen', function (Blueprint $table): void {
            $table->increments('Id');
            $table->string('naam', 100);
            $table->string('bestemming', 100)->nullable();
            $table->date('startdatum')->nullable();
            $table->date('einddatum')->nullable();
            $table->decimal('prijs', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reizen');
    }
};
