<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('reizen', function (Blueprint $table) {
        $table->id();
        $table->string('titel');
        $table->text('beschrijving');
        $table->decimal('prijs', 8, 2);
        $table->timestamps();
    });
}

    public function down(): void
    {
        Schema::dropIfExists('reizen');
    }
};
