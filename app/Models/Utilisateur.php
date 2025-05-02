<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Utilisateur extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'mot_de_passe',
        'nom',
        'role',
        'competences',
    ];

    protected $casts = [
        'competences' => 'array',
    ];

    public function equipes()
    {
        return $this->belongsToMany(Equipe::class);
    }

    public function taches()
    {
        return $this->belongsToMany(Tache::class);
    }

    public function projets()
    {
        return $this->hasMany(Projet::class);
    }
}
