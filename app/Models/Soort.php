<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Soort extends Model
{
    protected $fillable = ['naam'];
    protected $table = "soorten";


    public function aantalWaarnemingen() {
        return $this->hasMany(AantalWaarneming::class);
    }

}
