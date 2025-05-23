<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Projet extends Model
{
    use HasFactory;

    protected $fillable = ['nom', 'description', 'equipe_id'];

    public function equipe()
    {
        return $this->belongsTo(Equipe::class);
    }

    public function taches()
    {
        return $this->hasMany(Tache::class);
    }
}
