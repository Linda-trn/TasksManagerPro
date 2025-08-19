<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon; // Ajoutez cette ligne pour importer Carbon

class Tache extends Model
{
    use HasFactory;

    protected $fillable = [
    'titre', 
    'description',
    'priorite',
    'date_echeance',
    'heure_echeance',
    'rappel_actif',
    'date_rappel',  // Ajouté
    'heure_rappel', // Ajouté
    'user_id'
];
public function shouldSendReminder()
{
    return $this->rappel_actif && 
           !$this->rappel_envoye_a && 
           Carbon::parse($this->date_rappel.' '.$this->heure_rappel)->isPast();
}
    protected $dates = ['date_echeance'];

    public function users()
{
    return $this->belongsToMany(User::class, 'tache_user')
               ->withPivot('statut')
               ->withTimestamps();
}

    public function isLate()
    {
        $now = now();
        $echeance = Carbon::parse($this->date_echeance.' '.$this->heure_echeance);
        return $echeance->isBefore($now);
    }
    protected $casts = [
    'rappel' => 'boolean',
    'date_echeance' => 'date:Y-m-d',
    'date_rappel' => 'date:Y-m-d',
    'heure_echeance' => 'datetime:H:i',
    'heure_rappel' => 'datetime:H:i',
];

// In your Tache model
public function getHeureEcheanceAttribute($value)
{
    return $value ? Carbon::parse($value)->format('H:i') : null;
}

public function setHeureEcheanceAttribute($value)
{
    $this->attributes['heure_echeance'] = $value ?: null;
}



}