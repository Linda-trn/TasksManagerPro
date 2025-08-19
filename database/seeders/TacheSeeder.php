<?php

namespace Database\Seeders;

use App\Models\Tache;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class TacheSeeder extends Seeder
{
    public function run()
    {
        $user = User::first();
        
        if (!$user) {
            $user = User::factory()->create([
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'password' => bcrypt('password')
            ]);
        }
        
        // Tâches pour aujourd'hui
        Tache::factory()->count(3)->create([
            'date_echeance' => Carbon::today()
        ])->each(function ($tache) use ($user) {
            $user->taches()->attach($tache->id, ['statut' => 'en_attente']);
        });
        
        // Tâches en retard
        Tache::factory()->count(2)->create([
            'date_echeance' => Carbon::yesterday()
        ])->each(function ($tache) use ($user) {
            $user->taches()->attach($tache->id, ['statut' => 'en_retard']);
        });
        
        // Tâches futures
        Tache::factory()->count(5)->create([
            'date_echeance' => Carbon::tomorrow()->addDays(rand(1, 10))
        ])->each(function ($tache) use ($user) {
            $user->taches()->attach($tache->id, ['statut' => 'en_attente']);
        });
        
        // Tâches accomplies
        Tache::factory()->count(4)->create([
            'date_echeance' => Carbon::today()->subDays(rand(1, 5))
        ])->each(function ($tache) use ($user) {
            $user->taches()->attach($tache->id, [
                'statut' => 'accomplie',
                'accomplie_le' => Carbon::now()->subHours(rand(1, 12))
            ]);
        });
    }
}