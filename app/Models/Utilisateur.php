<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class Utilisateur extends Model
{
    use HasApiTokens, HasFactory;

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

    protected $hidden = [
        'mot_de_passe',
    ];

    public function equipes()
    {
        return $this->belongsToMany(Equipe::class, 'equipe_utilisateur', 'utilisateur_id', 'equipe_id')->withTimestamps();
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
