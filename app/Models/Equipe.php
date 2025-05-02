<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipe extends Model
{
    use HasFactory;

    protected $fillable = ['nom'];

    public function utilisateurs()
    {
        return $this->belongsToMany(Utilisateur::class);
    }

    public function projets()
    {
        return $this->hasMany(Projet::class);
    }
}
