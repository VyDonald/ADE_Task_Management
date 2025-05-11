<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tache extends Model
{
    use HasFactory;
    protected $fillable = [
        'titre',
        'description',
        'priorite',
        'statut',
        'date_debut',
        'date_echeance',
        'competences_requises',
        'projet_id',
        'utilisateur_id',
    ];

    protected $casts = [
       'competences_requises' => 'array',
        'date_debut' => 'date',
        'date_echeance' => 'date',
    ];

    public function projet()
    {
        return $this->belongsTo(Projet::class);
    }

    public function utilisateur()
    {
        return $this->belongsTo(Utilisateur::class);
    }
}
