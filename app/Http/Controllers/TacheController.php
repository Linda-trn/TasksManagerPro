<?php

namespace App\Http\Controllers;

use App\Models\Tache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TacheController extends Controller
{
   
public function index()
{
    if (!auth()->check()) {
        return redirect()->route('login'); // Redirige vers la page de connexion
    }
    $user = Auth::user();
    $now = Carbon::now();
    $today = Carbon::today();

    // Récupération des tâches
    $taches = $user->taches()
        ->whereDate('date_echeance', '<=', $today)
        ->wherePivot('statut', '!=', 'accomplie')
        ->orderBy('date_echeance')
        ->orderBy('heure_echeance')
        ->get();

    // Préparation des dates d'échéance
    $taches->each(function ($tache) {
        $tache->echeance = Carbon::createFromFormat(
            'Y-m-d H:i',
            $tache->date_echeance->format('Y-m-d') . ' ' . $tache->heure_echeance
        );
    });

    // Partition des tâches
    [$enRetard, $enAttente] = $taches->partition(function ($tache) use ($now) {
        return $now->greaterThan($tache->echeance);
    });

    // Calcul du retard
    $enRetard->each(function ($tache) use ($now) {
        $tache->retard = $now->diffInSeconds($tache->echeance);
    });

    return view('taches.index', [
        'enAttente' => $enAttente,  // Nom qui correspond à votre vue
        'enRetard' => $enRetard,
        'now' => $now
    ]);
}


public function create()
{
    return view('taches.create');
}





public function store(Request $request)
{
    $validated = $request->validate([
        'titre' => 'required|string|max:255',
        'description' => 'nullable|string',
        'priorite' => 'required|in:Haute,Moyenne,Basse',
        'date_echeance' => 'required|date|after_or_equal:today',
        'heure_echeance' => 'required',
        'rappel_actif' => 'sometimes|boolean',
        'date_rappel' => 'nullable|required_if:rappel_actif,1|date|after_or_equal:today',
        'heure_rappel' => 'nullable|required_if:rappel_actif,1',
    ]);

    $tache = Tache::create([
        'titre' => $validated['titre'],
        'description' => $validated['description'],
        'priorite' => $validated['priorite'],
        'date_echeance' => $validated['date_echeance'],
        'heure_echeance' => $validated['heure_echeance'],
        'rappel_actif' => $request->has('rappel_actif'),
        'date_rappel' => $request->has('rappel_actif') ? $validated['date_rappel'] : null,
        'heure_rappel' => $request->has('rappel_actif') ? $validated['heure_rappel'] : null,
    ]);

    // Associer la tâche à l'utilisateur connecté
    auth()->user()->taches()->attach($tache->id);

    return redirect()->route('taches.index')
        ->with('success', 'Tâche créée avec succès!');
}










   

    public function futures()
    {
        $tachesFutures = Auth::user()->taches()
            ->whereDate('date_echeance', '>', Carbon::today())
            ->wherePivot('statut', '!=', 'accomplie')
            ->orderBy('date_echeance')
            ->orderBy('heure_echeance')
            ->get();
            
        return view('taches.futures', compact('tachesFutures'));
    }
    
    public function accomplies()
    {
        $tachesAccomplies = Auth::user()->taches()
            ->wherePivot('statut', 'accomplie')
            ->orderByDesc('pivot_updated_at')
            ->get();
            
        return view('taches.accomplies', compact('tachesAccomplies'));
    }

    public function accomplir($id)
{
    try {
        $tache = Tache::findOrFail($id);
        $user = Auth::user();
        
        // Mettre à jour le statut dans la table pivot
        $user->taches()->updateExistingPivot($tache->id, ['statut' => 'accomplie']);
        
        return redirect()->route('taches.index')
            ->with('success', 'Tâche marquée comme accomplie avec succès');
    } catch (\Exception $e) {
        Log::error('Erreur lors de l\'accomplissement de la tâche: ' . $e->getMessage());
        return back()->with('error', 'Erreur lors de la mise à jour: ' . $e->getMessage());
    }
}

    public function show($id)
    {
        $tache = Auth::user()->taches()->findOrFail($id);
        return view('taches.show', compact('tache'));
    }

    public function edit($id)
    {
        $tache = Auth::user()->taches()->findOrFail($id);
        return view('taches.edit', compact('tache'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priorite' => 'required|in:Haute,Moyenne,Basse',
            'date_echeance' => 'required|date',
            'heure_echeance' => 'required|date_format:H:i',
            'rappel_actif' => 'sometimes|boolean',
            'date_rappel' => 'nullable|required_if:rappel_actif,1|date',
            'heure_rappel' => 'nullable|required_with:date_rappel|date_format:H:i'
        ]);

        try {
            DB::beginTransaction();

            $tache = Auth::user()->taches()->findOrFail($id);
            $ancienRappelActif = $tache->rappel_actif;
            $ancienneDateRappel = $tache->date_rappel;
            $ancienneHeureRappel = $tache->heure_rappel;

            // Préparation des données de mise à jour
            $updateData = [
                'titre' => $validated['titre'],
                'description' => $validated['description'],
                'priorite' => $validated['priorite'],
                'date_echeance' => $validated['date_echeance'],
                'heure_echeance' => $validated['heure_echeance'],
                'rappel_actif' => $request->boolean('rappel_actif'),
            ];

            // Gestion des rappels
            if ($request->boolean('rappel_actif')) {
                // Validation supplémentaire pour le rappel
                if (empty($validated['date_rappel'])) {
                    throw new \Exception('La date de rappel est requise');
                }
                if (empty($validated['heure_rappel'])) {
                    throw new \Exception('L\'heure de rappel est requise');
                }

                $updateData['date_rappel'] = $validated['date_rappel'];
                $updateData['heure_rappel'] = $validated['heure_rappel'];

                // Annuler l'ancien rappel si existant
                if ($ancienRappelActif) {
                    $this->annulerRappel($tache);
                }

                // Programmer le nouveau rappel
                $this->programmerRappel($tache);
            } else {
                $updateData['date_rappel'] = null;
                $updateData['heure_rappel'] = null;
                
                // Annuler le rappel si existant
                if ($ancienRappelActif) {
                    $this->annulerRappel($tache);
                }
            }

            // Mise à jour de la tâche
            $tache->update($updateData);

            DB::commit();

            return redirect()->route('taches.index')
                           ->with('success', 'Tâche mise à jour avec succès!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erreur update tâche: ' . $e->getMessage());
            return back()->with('error', 'Erreur lors de la mise à jour: ' . $e->getMessage());
        }
    }

    

    /**
     * Annule un rappel existant
     */
    protected function annulerRappel(Tache $tache)
    {
        // Implémentez ici la logique pour annuler le rappel
        // Par exemple, si vous utilisez des notifications ou des jobs :
        // Notification::cancelForTask($tache);
        Log::info("Rappel annulé pour la tâche #{$tache->id}");
    }

    /**
     * Programme un nouveau rappel
     */
    protected function programmerRappel(Tache $tache)
    {
        // Implémentez ici la logique pour programmer le rappel
        // Par exemple :
        // $dateRappel = Carbon::parse($tache->date_rappel.' '.$tache->heure_rappel);
        // Notification::scheduleForTask($tache, $dateRappel);
        Log::info("Nouveau rappel programmé pour la tâche #{$tache->id} à {$tache->date_rappel} {$tache->heure_rappel}");
    }

    public function destroy($id)
    {
        try {
            $tache = Tache::findOrFail($id);
            
            // Détacher la relation pour tous les utilisateurs
            $tache->users()->detach();
            
            // Supprimer la tâche
            $tache->delete();

            return redirect()->route('taches.index')
                           ->with('success', 'Tâche supprimée avec succès!');

        } catch (\Exception $e) {
            Log::error('Erreur suppression tâche: ' . $e->getMessage());
            return back()->with('error', 'Erreur lors de la suppression');
        }
    }


    
}