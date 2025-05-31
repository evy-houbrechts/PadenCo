<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dorp extends Model
{
    protected $fillable = ['naam'];
    protected $table = "dorpen";

    public function straten() {
        return $this->hasMany(Straat::class);
    }
    
}
