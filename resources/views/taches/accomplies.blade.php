@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-indigo-800">Tâches Accomplies</h1>
        <p class="text-gray-600 mt-2">Historique de toutes vos tâches terminées</p>
    </div>

    @if($tachesAccomplies->isEmpty())
        <div class="bg-white rounded-lg shadow-md p-6 text-center border border-gray-100">
            <div class="text-indigo-400 mb-3">
                <i class="fas fa-check-circle fa-3x"></i>
            </div>
            <p class="text-gray-500 text-lg">Aucune tâche accomplie pour le moment.</p>
            <p class="text-gray-400 mt-1">Lorsque vous marquerez des tâches comme terminées, elles apparaîtront ici.</p>
        </div>
    @else
        <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-100">
            <div class="divide-y divide-gray-100">
                @foreach($tachesAccomplies as $tache)
                    <div class="p-6 hover:bg-indigo-50 transition duration-150 ease-in-out">
                        <div class="flex justify-between items-start">
                            <div class="w-full">
                                <div class="flex justify-between items-start">
                                    <h3 class="font-semibold text-lg text-gray-800">{{ $tache->titre }}</h3>
                                    <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full">
                                        Terminée
                                    </span>
                                </div>
                                
                                @if($tache->description)
                                    <p class="text-sm text-gray-600 mt-2">{{ $tache->description }}</p>
                                @endif
                                
                                <div class="flex flex-wrap items-center mt-3 text-sm gap-4">
                                    @if($tache->date_echeance)
                                        <span class="text-gray-500 flex items-center">
                                            <i class="far fa-calendar mr-2 text-indigo-400"></i> 
                                            @if(is_string($tache->date_echeance))
                                                {{ \Carbon\Carbon::parse($tache->date_echeance)->format('d/m/Y') }}
                                            @else
                                                {{ $tache->date_echeance->format('d/m/Y') }}
                                            @endif
                                        </span>
                                    @endif
                                    
                                    @if($tache->heure_echeance)
                                        <span class="text-gray-500 flex items-center">
                                            <i class="far fa-clock mr-2 text-indigo-400"></i> 
                                            {{ $tache->heure_echeance }}
                                        </span>
                                    @endif
                                    
                                    @if($tache->pivot->accomplie_le)
                                        <span class="text-green-600 flex items-center">
                                            <i class="fas fa-check-circle mr-2 text-green-400"></i> 
                                            Accomplie le 
                                            @if(is_string($tache->pivot->accomplie_le))
                                                {{ \Carbon\Carbon::parse($tache->pivot->accomplie_le)->format('d/m/Y à H:i') }}
                                            @else
                                                {{ $tache->pivot->accomplie_le->format('d/m/Y à H:i') }}
                                            @endif
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        
        {{-- Suppression de la vérification hasPages() qui causait l'erreur --}}
        @if(method_exists($tachesAccomplies, 'links'))
            <div class="mt-6">
                {{ $tachesAccomplies->links() }}
            </div>
        @endif
    @endif
</div>
@endsection