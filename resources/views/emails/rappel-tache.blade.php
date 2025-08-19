@component('mail::message')
# Rappel de tâche

Bonjour {{ $user->name }},

Vous avez une tâche qui arrive à échéance :

**{{ $tache->titre }}**  
Date limite : {{ \Carbon\Carbon::createFromFormat('Y-m-d', $tache->date_echeance)->format('d/m/Y') }} à {{ $tache->heure_echeance }}

@if($tache->description)
> {{ $tache->description }}
@endif

@component('mail::button', ['url' => route('taches.index')])
Voir la tâche
@endcomponent

Merci,  
{{ config('app.name') }}
@endcomponent