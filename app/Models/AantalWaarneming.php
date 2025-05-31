<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AantalWaarneming extends Model
{
    protected $table = "aantal_waarnemingen";
    protected $fillable = ['waarneming_id', 'soort_id', 'categorie_id', 'aantal'];

public function waarneming() {
    return $this->belongsTo(Waarneming::class);
}

public function soort() {
    return $this->belongsTo(Soort::class);
    }
    
    public function categorie() {
        return $this->belongsTo(Categorie::class);
    }
    
}
