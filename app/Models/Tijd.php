<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tijd extends Model
{
    protected $table = "tijden";
    protected $fillable = ['moment'];

    public function agendas() {
        return $this->hasMany(Agenda::class);
    }

    public function waarnemingen() {
        return $this->hasMany(Waarneming::class);
    }
}
