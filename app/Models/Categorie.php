<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    protected $table = "categorieen";
    protected $fillable = ['label'];

    public function agendas() {
        return $this->hasMany(Agenda::class);     
    }

    public function straat() {
        return $this->belongsTo(Straat::class);
    }

    public function soort() {
        return $this->belongsTo(Soort::class);
    }

    public function waarnemingen() {
        return $this->hasMany(Waarneming::class);
    }
}
