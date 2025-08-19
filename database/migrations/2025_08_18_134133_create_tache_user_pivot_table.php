<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tache_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('tache_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            
            // Optionnel : empêche les doublons
            $table->unique(['user_id', 'tache_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('tache_user');
    }
};