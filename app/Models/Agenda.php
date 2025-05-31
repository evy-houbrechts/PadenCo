<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    protected $table = "agendas";
    protected $fillable = ['datum', 'straat_id', 'tijd_id', 'user_id'];
    protected $casts = [
        'datum' => 'date',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

public function tijd() {
    return $this->belongsTo(Tijd::class);
}

public function straat() {
    return $this->belongsTo(Straat::class);
}  
}
