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
        Schema::create('tache_user', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->foreignId('tache_id')->constrained()->onDelete('cascade');
    $table->string('statut')->default('en_attente'); // Champ supplémentaire
    $table->timestamps(); // created_at et updated_at
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tache_user', function (Blueprint $table) {
            //
        });
    }
};
