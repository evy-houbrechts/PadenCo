<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Waarneming extends Model
{

    protected $table = 'waarnemingen';
    protected $fillable = ['user_id', 'datum', 'straat_id', 'tijd_id'];

public function user() {
    return $this->belongsTo(User::class);
}

public function straat() {
    return $this->belongsTo(Straat::class);
}

public function tijd() {
    return $this->belongsTo(Tijd::class);
}

public function aantalWaarnemingen() {
    return $this->hasMany(AantalWaarneming::class);
}

}
