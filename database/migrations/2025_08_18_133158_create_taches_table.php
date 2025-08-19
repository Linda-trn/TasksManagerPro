<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('taches', function (Blueprint $table) {
            $table->id();
            $table->string('titre', 255);
            $table->text('description')->nullable();
            $table->enum('priorite', ['Haute', 'Moyenne', 'Basse']);
            $table->date('date_echeance');
            $table->time('heure_echeance');
            $table->timestamps();
            $table->boolean('rappel_actif')->default(false);
            $table->date('date_rappel')->nullable();
            $table->time('heure_rappel')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('taches');
    }
};