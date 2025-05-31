<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Straat extends Model
{
    protected $table = "straten";
    protected $fillable = ['naam'];

    public function dorp() {
        return $this->belongsTo(Dorp::class);
    }

    public function agendas() {
        return $this->hasMany(Agenda::class);
    }
    public function waarnemingen() {
        return $this->hasMany(Waarneming::class);
    }
    
}
