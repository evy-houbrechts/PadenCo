<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Support\Facades\Log;


class User extends Authenticatable implements FilamentUser
{
    /**
     * Bepaalt of deze gebruiker het opgegeven panel mag betreden.
     */

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
    ];

    public function canAccessPanel(Panel $panel): bool
    {
        Log::info('canAccessPanel aangeroepen voor gebruiker: ' . ($this->email ?? 'onbekend'));
        return $this->is_admin === true;
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected static function booted()
    {
        static::creating(function ($user) {
            $adminEmails = [
                'made4animals@gmail.com',
                'wesleybaldewijns@hotmail.com',
                'sergehoubrechts@live.be',
            ];

            if (in_array($user->email, $adminEmails)) {
                $user->is_admin = true;
            }
        });
    }

    // User.php
public function waarnemingen() {
    return $this->hasMany(Waarneming::class);
}

public function agendas() {
    return $this->hasMany(Agenda::class);
}


    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean',
        ];
    }
}
