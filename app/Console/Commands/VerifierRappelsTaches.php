<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Tache;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\RappelTache;



class VerifierRappelsTaches extends Command

{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rappels:verifier';
    
    
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Vérifie les tâches nécessitant un rappel et envoie des emails';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = Carbon::now();
        
        $taches = Tache::where('rappel_actif', true)
            ->whereNull('rappel_envoye_a')
            ->where('date_echeance', '<=', $now->format('Y-m-d'))
            ->where('heure_echeance', '<=', $now->format('H:i:s'))
            ->with('users')
            ->get();

        foreach ($taches as $tache) {
            foreach ($tache->users as $user) {
                if ($user->pivot->statut == 'en_attente') {
                    Mail::to($user->email)->send(new RappelTache($tache, $user));
                    
                    // Marquer que le rappel a été envoyé
                    $tache->update(['rappel_envoye_a' => $now]);
                }
            }
        }

        $this->info(count($taches).' rappels envoyés.');
    
    }
}
