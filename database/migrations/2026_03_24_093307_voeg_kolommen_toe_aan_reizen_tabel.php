<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reizen', function (Blueprint $table) {
            $table->string('land')->nullable()->after('titel');
            $table->string('afbeelding')->nullable()->after('prijs');
            $table->string('soort_reis')->default('Retour')->after('afbeelding');
            $table->boolean('promo')->default(false)->after('soort_reis');
        });
    }

    public function down(): void
    {
        Schema::table('reizen', function (Blueprint $table) {
            $table->dropColumn(['land', 'afbeelding', 'soort_reis', 'promo']);
        });
    }
};
