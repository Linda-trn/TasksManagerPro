@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white rounded-lg shadow p-6">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Créer une nouvelle tâche</h1>
    
    <form action="{{ route('taches.store') }}" method="POST">
        @csrf
        
        <div class="mb-4">
            <label for="titre" class="block text-gray-700 mb-2">Titre *</label>
            <input type="text" name="titre" id="titre" class="w-full px-3 py-2 border rounded-lg" required>
        </div>
        
        <div class="mb-4">
            <label for="description" class="block text-gray-700 mb-2">Description</label>
            <textarea name="description" id="description" rows="3" class="w-full px-3 py-2 border rounded-lg"></textarea>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label for="priorite" class="block text-gray-700 mb-2">Priorité *</label>
                <select name="priorite" id="priorite" class="w-full px-3 py-2 border rounded-lg" required>
                    <option value="Haute">Haute</option>
                    <option value="Moyenne" selected>Moyenne</option>
                    <option value="Basse">Basse</option>
                </select>
            </div>
            
            <div>
                <label for="date_echeance" class="block text-gray-700 mb-2">Date d'échéance *</label>
                <input type="date" name="date_echeance" id="date_echeance" class="w-full px-3 py-2 border rounded-lg" required>
            </div>
        </div>
        
        <div class="mb-6">
            <label for="heure_echeance" class="block text-gray-700 mb-2">Heure d'échéance *</label>
            <input type="time" name="heure_echeance" id="heure_echeance" class="w-full px-3 py-2 border rounded-lg" required>
        </div>

        <div class="mb-4">
            <label for="rappel_actif" class="flex items-center">
                <input type="checkbox" name="rappel_actif" id="rappel_actif" value="1"
       class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
       {{ old('rappel_actif') ? 'checked' : '' }}>
                <span class="ml-2 text-gray-700">Activer le rappel par email</span>
            </label>
        </div>

        <div id="rappel_fields" class="hidden mb-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="date_rappel" class="block text-gray-700 mb-2">Date de rappel *</label>
                    <input type="date" name="date_rappel" id="date_rappel" class="w-full px-3 py-2 border rounded-lg">
                </div>
                
                <div>
                    <label for="heure_rappel" class="block text-gray-700 mb-2">Heure de rappel *</label>
                    <input type="time" name="heure_rappel" id="heure_rappel" class="w-full px-3 py-2 border rounded-lg">
                </div>
            </div>
        </div>
        
        <div class="flex justify-end space-x-3">
            <a href="{{ route('taches.index') }}" class="px-4 py-2 border rounded-lg">Annuler</a>
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg">Créer la tâche</button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    // Définir la date minimale comme aujourd'hui
    document.getElementById('date_echeance').min = new Date().toISOString().split('T')[0];
    
    // Afficher/masquer les champs de rappel
    const rappelCheckbox = document.getElementById('rappel_actif');
    const rappelFields = document.getElementById('rappel_fields');
    
    // Dans votre script
rappelCheckbox.addEventListener('change', function() {
    if (this.checked) {
        rappelFields.classList.remove('hidden');
        // Définir la date de rappel par défaut à aujourd'hui
        document.getElementById('date_rappel').value = new Date().toISOString().split('T')[0];
        // Définir l'heure de rappel par défaut
        document.getElementById('heure_rappel').value = '00:00';
    } else {
        rappelFields.classList.add('hidden');
        // Réinitialiser les valeurs
        document.getElementById('date_rappel').value = '';
        document.getElementById('heure_rappel').value = '';
    }
});
    // Initialiser l'état au chargement de la page
    if (rappelCheckbox.checked) {
        rappelFields.classList.remove('hidden');
        document.getElementById('date_rappel').required = true;
        document.getElementById('heure_rappel').required = true;
    }
</script>
@endpush
@endsection