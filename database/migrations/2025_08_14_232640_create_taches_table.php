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
        Schema::create('taches', function (Blueprint $table) {
    $table->id();
    $table->string('titre', 255);
    $table->text('description')->nullable();
    $table->enum('priorite', ['Haute', 'Moyenne', 'Basse']);
    $table->date('date_echeance');
    $table->time('heure_echeance');
    $table->timestamps();
    $table->boolean('rappel_actif')->default(false)->after('heure_echeance');
    $table->date('date_rappel')->nullable()->after('rappel_actif');
    $table->time('heure_rappel')->nullable()->after('date_rappel');
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('taches');
    }
};
