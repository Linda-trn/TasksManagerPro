@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-lg p-6">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Modifier la tâche</h1>
            <a href="{{ route('taches.index') }}" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times text-xl"></i>
            </a>
        </div>

        @if ($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    <div>
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        <form action="{{ route('taches.update', $tache->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="space-y-6">
                <!-- Section principale -->
                <div class="bg-blue-50 p-4 rounded-lg">
                    <h2 class="text-lg font-semibold text-blue-800 mb-4 flex items-center">
                        <i class="fas fa-tasks mr-2"></i> Détails de la tâche
                    </h2>
                    
                    <div class="space-y-4">
                        <div>
                            <label for="titre" class="block text-sm font-medium text-gray-700 mb-1">Titre *</label>
                            <input type="text" name="titre" id="titre" 
                                   value="{{ old('titre', $tache->titre) }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 shadow-sm">
                        </div>
                        
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                            <textarea name="description" id="description" rows="3"
                                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 shadow-sm">{{ old('description', $tache->description) }}</textarea>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="priorite" class="block text-sm font-medium text-gray-700 mb-1">Priorité *</label>
                                <select name="priorite" id="priorite" 
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 shadow-sm">
                                    <option value="Haute" {{ old('priorite', $tache->priorite) == 'Haute' ? 'selected' : '' }}>Haute</option>
                                    <option value="Moyenne" {{ old('priorite', $tache->priorite) == 'Moyenne' ? 'selected' : '' }}>Moyenne</option>
                                    <option value="Basse" {{ old('priorite', $tache->priorite) == 'Basse' ? 'selected' : '' }}>Basse</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Section échéance -->
                <div class="bg-purple-50 p-4 rounded-lg">
                    <h2 class="text-lg font-semibold text-purple-800 mb-4 flex items-center">
                        <i class="far fa-calendar-alt mr-2"></i> Échéance
                    </h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="date_echeance" class="block text-sm font-medium text-gray-700 mb-1">Date *</label>
                            <input type="date" name="date_echeance" id="date_echeance" 
                                   value="{{ old('date_echeance', $tache->date_echeance) }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 shadow-sm">
                        </div>
                        
                        <div>
                            <label for="heure_echeance" class="block text-sm font-medium text-gray-700 mb-1">Heure *</label>
                            <input type="time" name="heure_echeance" id="heure_echeance" 
                                   value="{{ old('heure_echeance', substr($tache->heure_echeance, 0, 5)) }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 shadow-sm">
                        </div>
                    </div>
                </div>
                
                <!-- Section rappel -->
                <div class="bg-yellow-50 p-4 rounded-lg">
                    <h2 class="text-lg font-semibold text-yellow-800 mb-4 flex items-center">
                        <i class="fas fa-bell mr-2"></i> Rappel
                    </h2>
                    
                    <div class="space-y-4">
                        <input type="hidden" name="rappel_actif" value="0">
        <div class="flex items-center">
            <input type="checkbox" name="rappel_actif" id="rappel_actif" 
                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                   value="1"
                   {{ old('rappel_actif', $tache->rappel_actif) ? 'checked' : '' }}>
            <label for="rappel_actif" class="ml-2 block text-sm font-medium text-gray-700">
                Activer le rappel
            </label>
        </div>
                        
                        <div id="rappel_fields" class="{{ old('rappel_actif', $tache->rappel_actif) ? '' : 'hidden' }} space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="date_rappel" class="block text-sm font-medium text-gray-700 mb-1">Date de rappel</label>
                                    <input type="date" name="date_rappel" id="date_rappel" 
                                           value="{{ old('date_rappel', $tache->date_rappel) }}"
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 shadow-sm">
                                </div>
                                
                                <div>
                                    <label for="heure_rappel" class="block text-sm font-medium text-gray-700 mb-1">Heure de rappel</label>
                                    <input type="time" name="heure_rappel" id="heure_rappel" 
                                           value="{{ old('heure_rappel', $tache->heure_rappel ? substr($tache->heure_rappel, 0, 5) : '') }}"
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 shadow-sm">
                                </div>
                            </div>
                            
                            <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-3 rounded">
                                <p class="text-sm flex items-center">
                                    <i class="fas fa-info-circle mr-2"></i>
                                    Le rappel doit être programmé avant l'échéance de la tâche.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Boutons de soumission -->
                <div class="flex justify-end space-x-3 pt-4">
                    <a href="{{ route('taches.index') }}" class="px-5 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors font-medium">
                        Annuler
                    </a>
                    <button type="submit" class="px-5 py-2 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg hover:from-blue-600 hover:to-blue-700 transition-colors font-medium shadow-md">
                        <i class="fas fa-save mr-2"></i> Enregistrer
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    // Afficher/masquer les champs de rappel
    document.getElementById('rappel_actif').addEventListener('change', function() {
        const rappelFields = document.getElementById('rappel_fields');
        if (this.checked) {
            rappelFields.classList.remove('hidden');
        } else {
            rappelFields.classList.add('hidden');
        }
    });
    
    // Validation des dates
    document.querySelector('form').addEventListener('submit', function(e) {
        const rappelActif = document.getElementById('rappel_actif').checked;
        const dateRappel = document.getElementById('date_rappel').value;
        const heureRappel = document.getElementById('heure_rappel').value;
        const dateEcheance = document.getElementById('date_echeance').value;
        
        if (rappelActif && (!dateRappel || !heureRappel)) {
            e.preventDefault();
            alert('Veuillez remplir tous les champs de rappel');
            return false;
        }
        
        if (rappelActif && dateRappel && dateEcheance) {
            if (new Date(dateRappel) > new Date(dateEcheance)) {
                e.preventDefault();
                alert('La date de rappel doit être avant la date d\'échéance');
                return false;
            }
        }
    });
</script>
@endpush
@endsection