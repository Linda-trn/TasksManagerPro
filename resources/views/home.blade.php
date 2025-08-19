@extends('layouts.app')

@section('content')
@php
    $user = auth()->user();
    $now = now();
    $today = $now->format('Y-m-d');
    
    // Récupération des tâches avec leur statut
    $taches = $user->taches()
        ->withPivot('statut')
        ->get()
        ->map(function($tache) use ($now, $today) {
            try {
                // Création de l'objet Carbon pour l'échéance
                $dateEcheance = \Carbon\Carbon::createFromFormat('Y-m-d', $tache->date_echeance);
                $heureEcheance = \Carbon\Carbon::createFromTimeString($tache->heure_echeance);
                
                $echeance = $dateEcheance->copy()->setTime(
                    $heureEcheance->hour,
                    $heureEcheance->minute,
                    $heureEcheance->second
                );
                
                $tache->isLate = $echeance < $now && $tache->pivot->statut != 'accomplie';
                $tache->isToday = $tache->date_echeance == $today;
                $tache->echeance = $echeance;
            } catch (Exception $e) {
                $tache->isLate = false;
                $tache->isToday = false;
                $tache->echeance = $now;
            }
            return $tache;
        })
        ->sortBy(function($tache) {
            return [
                !$tache->isLate,    // Les tâches en retard en premier (false < true)
                !$tache->isToday,   // Puis les tâches d'aujourd'hui
                $tache->echeance    // Enfin tri par date/heure
            ];
        });
    
    // Filtrage précis des tâches
    $tachesAujourdhui = $taches->filter(function($tache) use ($today) {
        return $tache->date_echeance == $today && $tache->pivot->statut == 'en_attente';
    });
    
    $tachesEnRetard = $taches->filter(function($tache) {
        return $tache->isLate;
    });
    
    $tachesTerminees = $taches->filter(function($tache) {
        return $tache->pivot->statut == 'accomplie';
    });
@endphp

<div class="container mx-auto px-4 py-8">
    <!-- En-tête -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Tableau de bord</h1>
            <p class="text-gray-600">Bonjour {{ $user->name }}, voici vos tâches</p>
        </div>
        <a href="{{ route('taches.create') }}" 
           class="flex items-center bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
            </svg>
            Nouvelle tâche
        </a>
    </div>

    <!-- Statistiques -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
        <div class="bg-white p-4 rounded-lg shadow border-l-4 border-blue-500">
            <h3 class="text-gray-700 font-medium">Aujourd'hui</h3>
            <p class="text-2xl font-bold text-gray-800">{{ $tachesAujourdhui->count() }}</p>
            <p class="text-sm text-gray-500">Tâches prévues pour aujourd'hui</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow border-l-4 border-red-500">
            <h3 class="text-gray-700 font-medium">En retard</h3>
            <p class="text-2xl font-bold text-gray-800">{{ $tachesEnRetard->count() }}</p>
            <p class="text-sm text-gray-500">Tâches non terminées après échéance</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow border-l-4 border-green-500">
            <h3 class="text-gray-700 font-medium">Terminées</h3>
            <p class="text-2xl font-bold text-gray-800">{{ $tachesTerminees->count() }}</p>
            <p class="text-sm text-gray-500">Tâches accomplies</p>
        </div>
    </div>

    <!-- Liste des tâches -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-3 bg-gray-50 border-b flex justify-between items-center">
            <h2 class="font-semibold text-gray-800">Toutes les tâches</h2>
            <div class="flex space-x-2">
                <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded-full">Aujourd'hui: {{ $tachesAujourdhui->count() }}</span>
                <span class="text-xs bg-red-100 text-red-800 px-2 py-1 rounded-full">Retard: {{ $tachesEnRetard->count() }}</span>
            </div>
        </div>
        
        @if($taches->isEmpty())
            <div class="p-8 text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                <p class="mt-2 text-gray-600">Aucune tâche trouvée</p>
                <a href="{{ route('taches.create') }}" class="mt-4 inline-block bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                    Créer votre première tâche
                </a>
            </div>
        @else
            <div class="divide-y divide-gray-200">
                @foreach($taches as $tache)
                <div class="p-4 hover:bg-gray-50 transition-colors
                    {{ $tache->isLate ? 'bg-red-50' : '' }}
                    {{ $tache->isToday && !$tache->isLate ? 'bg-blue-50' : '' }}">
                    <div class="flex justify-between items-start">
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2">
                                <h3 class="font-medium text-gray-800 truncate">{{ $tache->titre }}</h3>
                                <span class="px-2 py-1 text-xs rounded-full 
                                    {{ $tache->pivot->statut == 'accomplie' ? 'bg-green-100 text-green-800' : 
                                    ($tache->isLate ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800') }}">
                                    {{ $tache->pivot->statut == 'accomplie' ? 'Terminée' : 
                                    ($tache->isLate ? 'En retard' : ($tache->isToday ? 'Aujourd\'hui' : 'Future')) }}
                                </span>
                            </div>
                            
                            @if($tache->description)
                                <p class="mt-1 text-sm text-gray-600">{{ Str::limit($tache->description, 120) }}</p>
                            @endif
                            
                            <div class="mt-2 flex flex-wrap items-center gap-3 text-sm text-gray-500">
                                @if($tache->rappel_actif)
                                    <span class="flex items-center" title="Rappel activé">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-yellow-500" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                        </svg>
                                        Rappel
                                    </span>
                                @endif
                                
                                <span class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                                    </svg>
                                    {{ $tache->echeance->format('d/m/Y') }}
                                </span>
                                
                                <span class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                    </svg>
                                    {{ $tache->echeance->format('H:i') }}
                                </span>
                                
                                <span class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd" />
                                    </svg>
                                    {{ $tache->priorite }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="flex space-x-2">
                            @if($tache->pivot->statut != 'accomplie')
                                <form action="{{ route('taches.accomplir', $tache->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="p-1 text-green-600 hover:bg-green-100 rounded-full" title="Marquer comme terminée">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </form>
                            @endif
                            
                            <a href="{{ route('taches.edit', $tache->id) }}" class="p-1 text-blue-600 hover:bg-blue-100 rounded-full" title="Modifier">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection