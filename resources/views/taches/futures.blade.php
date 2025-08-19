@extends('layouts.app')

@section('content')
<div class="mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
    <div>
        <h1 class="text-3xl font-bold text-gray-800">Tâches Futures</h1>
        <p class="text-gray-500">{{ now()->format('l, j F Y') }}</p>
    </div>
    <div class="flex gap-3">
        <a href="{{ route('home') }}" class="bg-gray-700 hover:bg-gray-800 text-white px-6 py-3 rounded-lg flex items-center shadow transition-colors">
            <i class="fas fa-home mr-2"></i> Page d'Accueil
        </a>
        <a href="{{ route('taches.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg flex items-center shadow transition-colors">
            <i class="fas fa-plus mr-2"></i> Nouvelle Tâche
        </a>
    </div>
</div>

@if(session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded">
        <div class="flex items-center">
            <i class="fas fa-check-circle mr-2"></i>
            <p>{{ session('success') }}</p>
        </div>
    </div>
@endif

@if($tachesFutures->isEmpty())
    <div class="bg-white rounded-lg shadow p-8 text-center">
        <i class="far fa-calendar-check text-gray-300 text-5xl mb-4"></i>
        <p class="text-gray-500 text-lg">Aucune tâche future programmée</p>
    </div>
@else
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="divide-y divide-gray-100">
            @foreach($tachesFutures as $tache)
                <div class="p-6 hover:bg-gray-50 transition-colors">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                        <div class="flex-1">
                            <h3 class="text-lg font-medium text-gray-800">{{ $tache->titre }}</h3>
                            @if($tache->description)
                                <p class="text-sm text-gray-600 mt-1">{{ $tache->description }}</p>
                            @endif
                            <div class="flex flex-wrap items-center mt-3 gap-2">
                                <span class="inline-flex items-center text-sm text-gray-600 bg-gray-50 px-3 py-1 rounded-full border border-gray-200">
                                    <i class="far fa-calendar mr-2 text-gray-500"></i>
                                    {{ \Carbon\Carbon::parse($tache->date_echeance)->format('d/m/Y') }}
                                </span>
                                <span class="inline-flex items-center text-sm text-gray-600 bg-gray-50 px-3 py-1 rounded-full border border-gray-200">
                                    <i class="far fa-clock mr-2 text-gray-500"></i>
                                    {{ $tache->heure_echeance }}
                                </span>
                                <span class="inline-flex items-center text-xs font-medium px-3 py-1 rounded-full border 
                                    {{ $tache->priorite === 'Haute' ? 'bg-red-50 text-red-700 border-red-200' : 
                                       ($tache->priorite === 'Moyenne' ? 'bg-yellow-50 text-yellow-700 border-yellow-200' : 'bg-green-50 text-green-700 border-green-200') }}">
                                    {{ $tache->priorite }}
                                </span>
                            </div>
                            
                            <!-- Section Rappel -->
                            @if($tache->rappel_actif)
                                <div class="mt-3 bg-blue-50 border border-blue-100 rounded-lg p-3">
                                    <div class="flex items-center text-blue-800">
                                        <i class="fas fa-bell mr-2"></i>
                                        <span class="font-medium">Rappel programmé</span>
                                    </div>
                                    <div class="flex flex-wrap items-center mt-1 gap-2">
                                        <span class="inline-flex items-center text-xs text-blue-700 bg-blue-100 px-2 py-0.5 rounded-full">
                                            <i class="far fa-calendar mr-1"></i>
                                            {{ \Carbon\Carbon::parse($tache->date_rappel)->format('d/m/Y') }}
                                        </span>
                                        <span class="inline-flex items-center text-xs text-blue-700 bg-blue-100 px-2 py-0.5 rounded-full">
                                            <i class="far fa-clock mr-1"></i>
                                            {{ $tache->heure_rappel }}
                                        </span>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="flex gap-2">
                            <form action="{{ route('taches.accomplir', $tache->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="text-green-600 hover:text-green-800 p-2 rounded-full hover:bg-green-50" title="Marquer comme accomplie">
                                    <i class="fas fa-check"></i>
                                </button>
                            </form>
                            <a href="{{ route('taches.edit', $tache->id) }}" class="text-blue-600 hover:text-blue-800 p-2 rounded-full hover:bg-blue-50" title="Modifier">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button onclick="openReporterModal({{ $tache->id }})" class="text-purple-600 hover:text-purple-800 p-2 rounded-full hover:bg-purple-50" title="Reporter">
                                <i class="fas fa-calendar-plus"></i>
                            </button>
                            <button onclick="openRappelModal({{ $tache->id }}, '{{ $tache->date_rappel }}', '{{ $tache->heure_rappel }}')" 
                                class="text-yellow-600 hover:text-yellow-800 p-2 rounded-full hover:bg-yellow-50" 
                                title="{{ $tache->rappel_actif ? 'Modifier le rappel' : 'Ajouter un rappel' }}">
                                <i class="fas {{ $tache->rappel_actif ? 'fa-bell' : 'fa-bell-slash' }}"></i>
                            </button>
                            <form action="{{ route('taches.destroy', $tache->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 p-2 rounded-full hover:bg-red-50" title="Supprimer" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette tâche ?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif

<!-- Modal pour reporter une tâche -->
<div id="reporterModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-md mx-4">
        <div class="px-6 py-4 border-b">
            <h3 class="text-xl font-semibold text-gray-800">Reporter la tâche</h3>
        </div>
        <form id="reporterForm" method="POST" class="p-6">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2">Nouvelle date</label>
                <input type="date" name="date_echeance" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                       min="{{ now()->format('Y-m-d') }}" required>
            </div>
            <div class="mb-6">
                <label class="block text-gray-700 font-medium mb-2">Nouvelle heure</label>
                <input type="time" name="heure_echeance" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
            </div>
            <div class="flex justify-end space-x-3">
                <button type="button" onclick="closeReporterModal()" class="px-5 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                    Annuler
                </button>
                <button type="submit" class="px-5 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    Reporter
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal pour gérer les rappels -->
<div id="rappelModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-md mx-4">
        <div class="px-6 py-4 border-b">
            <h3 class="text-xl font-semibold text-gray-800">Gérer le rappel</h3>
        </div>
        <form id="rappelForm" method="POST" class="p-6">
            @csrf
            <div class="mb-4">
                <label class="flex items-center space-x-3">
                    <input type="checkbox" name="rappel_actif" id="rappelActif" class="form-checkbox h-5 w-5 text-blue-600 rounded focus:ring-blue-500">
                    <span class="text-gray-700 font-medium">Activer le rappel</span>
                </label>
            </div>
            <div id="rappelFields" class="space-y-4 hidden">
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Date du rappel</label>
                    <input type="date" name="date_rappel" id="dateRappel" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                           min="{{ now()->format('Y-m-d') }}">
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Heure du rappel</label>
                    <input type="time" name="heure_rappel" id="heureRappel" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>
            <div class="flex justify-end space-x-3 mt-6">
                <button type="button" onclick="closeRappelModal()" class="px-5 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                    Annuler
                </button>
                <button type="submit" class="px-5 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    Enregistrer
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
    }
    
    function closeReporterModal() {
        document.getElementById('reporterModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    function openRappelModal(tacheId, dateRappel, heureRappel) {
        const modal = document.getElementById('rappelModal');
        const form = document.getElementById('rappelForm');
        const rappelFields = document.getElementById('rappelFields');
        const rappelActif = document.getElementById('rappelActif');
        
        form.action = `/taches/${tacheId}/rappel`;
        
        if (dateRappel && heureRappel) {
            rappelActif.checked = true;
            document.getElementById('dateRappel').value = dateRappel;
            document.getElementById('heureRappel').value = heureRappel;
            rappelFields.classList.remove('hidden');
        }
        
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
    
    function closeRappelModal() {
        document.getElementById('rappelModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    document.getElementById('rappelActif').addEventListener('change', function(e) {
        const rappelFields = document.getElementById('rappelFields');
        if (e.target.checked) {
            rappelFields.classList.remove('hidden');
        } else {
            rappelFields.classList.add('hidden');
        }
    });

    document.getElementById('reporterModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeReporterModal();
        }
    });

    document.getElementById('rappelModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeRappelModal();
        }
    });
</script>
@endpush
@endsection