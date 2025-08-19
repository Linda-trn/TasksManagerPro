@extends('layouts.app')

@section('content')
<div class="mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
    <div>
        <h1 class="text-3xl font-bold text-gray-800">Gestion des Tâches</h1>
        <p class="text-gray-600">{{ now()->isoFormat('dddd, D MMMM YYYY') }}</p>
    </div>
    <div class="flex gap-3 flex-wrap">
        <a href="{{ route('taches.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg flex items-center shadow-md transition-colors">
            <i class="fas fa-plus mr-2"></i> Nouvelle Tâche
        </a>
    </div>
</div>

@if(session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg shadow-sm">
        <div class="flex items-center">
            <i class="fas fa-check-circle mr-2 text-green-500"></i>
            <p>{{ session('success') }}</p>
        </div>
    </div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Tâches en attente -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
        <div class="bg-blue-600 px-6 py-4 flex items-center justify-between">
    <h2 class="text-xl font-semibold text-white flex items-center">
        <i class="fas fa-clock mr-3"></i> Tâches en Attente
    </h2>
    <span class="bg-blue-500 text-white px-3 py-1 rounded-full text-sm font-medium">
        {{ isset($enAttente) ? $enAttente->count() : 0 }}
    </span>
</div>

<div class="p-6">
    @if(!isset($enAttente) || $enAttente->isEmpty())
        <div class="text-center py-8">
            <i class="far fa-smile-beam text-gray-300 text-5xl mb-3"></i>
            <p class="text-gray-500 font-medium">Aucune tâche en attente aujourd'hui</p>
        </div>
    @else
        <div class="space-y-4">
            @foreach($enAttente as $tache)
                     <div class="border-l-4 border-blue-500 bg-blue-50 bg-opacity-30 pl-4 py-3 hover:bg-blue-50 transition-colors rounded-r-lg">
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <h3 class="font-medium text-gray-800 flex items-center">
                                        {{ $tache->titre }}
                                        @if($tache->priorite === 'Haute')
                                            <span class="ml-2 text-xs font-medium px-2 py-0.5 rounded-full bg-red-100 text-red-800">
                                                <i class="fas fa-exclamation-circle mr-1"></i> Priorité haute
                                            </span>
                                        @endif
                                    </h3>
                                    @if($tache->description)
                                        <p class="text-sm text-gray-600 mt-1">{{ Str::limit($tache->description, 100) }}</p>
                                    @endif
                                    <div class="flex flex-wrap items-center mt-2 gap-2">
                                        <span class="inline-flex items-center text-sm text-gray-600 bg-white px-3 py-1 rounded-full shadow-sm">
                                            <i class="far fa-calendar-alt mr-1 text-blue-500"></i>
                                            {{ \Carbon\Carbon::parse($tache->date_echeance)->isoFormat('DD/MM/YY') }}
                                            à {{ \Carbon\Carbon::parse($tache->heure_echeance)->format('H:i') }}
                                        </span>
                                        <span class="inline-flex items-center text-xs font-medium px-2.5 py-0.5 rounded-full 
                                            {{ $tache->priorite === 'Haute' ? 'bg-red-100 text-red-800' : 
                                               ($tache->priorite === 'Moyenne' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800') }}">
                                            {{ $tache->priorite }}
                                        </span>
                                        @if($tache->rappel_actif && $tache->date_rappel && $tache->heure_rappel)
                                            <span class="inline-flex items-center text-sm text-gray-600 bg-white px-3 py-1 rounded-full shadow-sm">
                                                <i class="fas fa-bell mr-1 text-purple-500"></i>
                                                Rappel: {{ \Carbon\Carbon::parse($tache->date_rappel)->isoFormat('DD/MM/YY') }}
                                                à {{ \Carbon\Carbon::parse($tache->heure_rappel)->format('H:i') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex space-x-2 ml-4">
                                    <form action="{{ route('taches.accomplir', $tache->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="text-green-600 hover:text-green-800 p-2 rounded-full hover:bg-green-100 transition-colors" title="Marquer comme accomplie">
                                            <i class="fas fa-check-circle"></i>
                                        </button>
                                    </form>
                                    <a href="{{ route('taches.edit', $tache->id) }}" class="text-blue-600 hover:text-blue-800 p-2 rounded-full hover:bg-blue-100 transition-colors" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button onclick="openReporterModal({{ $tache->id }})" class="text-purple-600 hover:text-purple-800 p-2 rounded-full hover:bg-purple-100 transition-colors" title="Reporter">
                                        <i class="fas fa-calendar-plus"></i>
                                    </button>
                                    <form action="{{ route('taches.destroy', $tache->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 p-2 rounded-full hover:bg-red-100 transition-colors" title="Supprimer" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette tâche ?')">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
    
    <!-- Tâches en retard -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
        <div class="bg-red-600 px-6 py-4 flex items-center justify-between">
            <h2 class="text-xl font-semibold text-white flex items-center">
                <i class="fas fa-exclamation-triangle mr-3"></i> Tâches en Retard
            </h2>
            <span class="bg-red-500 text-white px-3 py-1 rounded-full text-sm font-medium">
                 {{ isset($enRetard) ? $enRetard->count() : 0 }}
            </span>
        </div>
        
        <div class="p-6">
            @if(!isset($enRetard) || $enRetard->isEmpty())
                <div class="text-center py-8">
                    <i class="far fa-thumbs-up text-gray-300 text-5xl mb-3"></i>
                    <p class="text-gray-500 font-medium">Aucune tâche en retard - Excellent travail !</p>
                </div>
            @else
                <div class="space-y-4">
                    @foreach($enRetard as $tache)
                        <div class="border-l-4 border-red-500 bg-red-50 bg-opacity-30 pl-4 py-3 hover:bg-red-50 transition-colors rounded-r-lg">
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <h3 class="font-medium text-gray-800 flex items-center">
                                        {{ $tache->titre }}
                                        <span class="ml-2 text-xs font-medium px-2 py-0.5 rounded-full bg-red-100 text-red-800">
                                            <i class="fas fa-exclamation-triangle mr-1"></i> En retard
                                        </span>
                                    </h3>
                                    @if($tache->description)
                                        <p class="text-sm text-gray-600 mt-1">{{ Str::limit($tache->description, 100) }}</p>
                                    @endif
                                    <div class="flex flex-wrap items-center mt-2 gap-2">
                                        <span class="inline-flex items-center text-sm text-gray-600 bg-white px-3 py-1 rounded-full shadow-sm">
                                            <i class="far fa-calendar-alt mr-1 text-red-500"></i>
                                            {{ \Carbon\Carbon::parse($tache->date_echeance)->isoFormat('DD/MM/YY') }}
                                            à {{ \Carbon\Carbon::parse($tache->heure_echeance)->format('H:i') }}
                                        </span>
                                        <span class="inline-flex items-center text-xs font-medium px-2.5 py-0.5 rounded-full bg-red-100 text-red-800">
                                            {{ $tache->priorite }}
                                        </span>
                                        @if($tache->rappel_actif && $tache->date_rappel && $tache->heure_rappel)
                                            <span class="inline-flex items-center text-sm text-gray-600 bg-white px-3 py-1 rounded-full shadow-sm">
                                                <i class="fas fa-bell mr-1 text-purple-500"></i>
                                                Rappel: {{ \Carbon\Carbon::parse($tache->date_rappel)->isoFormat('DD/MM/YY') }}
                                                à {{ \Carbon\Carbon::parse($tache->heure_rappel)->format('H:i') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex space-x-2 ml-4">
                                    <form action="{{ route('taches.accomplir', $tache->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="text-green-600 hover:text-green-800 p-2 rounded-full hover:bg-green-100 transition-colors" title="Marquer comme accomplie">
                                            <i class="fas fa-check-circle"></i>
                                        </button>
                                    </form>
                                    <a href="{{ route('taches.edit', $tache->id) }}" class="text-blue-600 hover:text-blue-800 p-2 rounded-full hover:bg-blue-100 transition-colors" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button onclick="openReporterModal({{ $tache->id }})" class="text-purple-600 hover:text-purple-800 p-2 rounded-full hover:bg-purple-100 transition-colors" title="Reporter">
                                        <i class="fas fa-calendar-plus"></i>
                                    </button>
                                    <form action="{{ route('taches.destroy', $tache->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 p-2 rounded-full hover:bg-red-100 transition-colors" title="Supprimer" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette tâche ?')">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal pour reporter une tâche -->
<div id="reporterModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden transition-opacity duration-300">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-md mx-4 transform transition-all duration-300">
        <div class="px-6 py-4 border-b bg-gradient-to-r from-blue-500 to-blue-600 rounded-t-xl">
            <h3 class="text-xl font-semibold text-white">Reporter la tâche</h3>
        </div>
        <form id="reporterForm" method="POST" class="p-6">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2">Nouvelle date</label>
                <input type="date" name="date_echeance" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 shadow-sm" 
                       min="{{ now()->format('Y-m-d') }}" required>
            </div>
            <div class="mb-6">
                <label class="block text-gray-700 font-medium mb-2">Nouvelle heure</label>
                <input type="time" name="heure_echeance" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 shadow-sm" required>
            </div>
            <div class="flex justify-end space-x-3">
                <button type="button" onclick="closeReporterModal()" class="px-5 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors font-medium">
                    Annuler
                </button>
                <button type="submit" class="px-5 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium shadow-md">
                    <i class="fas fa-calendar-check mr-2"></i> Reporter
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function openReporterModal(tacheId) {
        const modal = document.getElementById('reporterModal');
        const form = document.getElementById('reporterForm');
        
        form.action = `/taches/${tacheId}/reporter`;
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        
        // Animation
        setTimeout(() => {
            modal.querySelector('div').classList.add('scale-100');
        }, 10);
    }
    
    function closeReporterModal() {
        const modal = document.getElementById('reporterModal');
        modal.querySelector('div').classList.remove('scale-100');
        
        setTimeout(() => {
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }, 300);
    }

    // Fermer la modal en cliquant à l'extérieur
    document.getElementById('reporterModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeReporterModal();
        }
    });
</script>
@endpush
@endsection