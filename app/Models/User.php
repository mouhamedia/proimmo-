<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    // Création automatique d'une résidence à la création d'un utilisateur (en 2 temps)
    protected static function booted()
    {
        static::created(function ($user) {
            // Création automatique de résidence uniquement pour les gestionnaires
            if ($user->role === 'manager' && empty($user->residence_id)) {
                $residence = \App\Models\Residence::create([
                    'name' => 'Résidence de ' . $user->name,
                    'address' => '',
                    'owner_id' => $user->id,
                ]);
                $user->residence_id = $residence->id;
                $user->save();
            }
        });
    }
        // Appartement actif du locataire (attribut dynamique)
        public function getApartmentAttribute()
        {
            // Récupère l'appartement courant (end_date null, le plus récent sinon)
            return $this->apartments()
                ->wherePivot('end_date', null)
                ->orderByDesc('tenant_apartments.start_date')
                ->first();
        }
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
        'role',
        'residence_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

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
        ];
    }
    
    // Relation avec la résidence
    public function residence()
    {
        return $this->belongsTo(Residence::class);
    }

    // Un gestionnaire possède plusieurs résidences
    public function residences()
    {
        return $this->hasMany(Residence::class, 'owner_id');
    }

    // Un locataire a plusieurs paiements
    public function payments()
    {
        return $this->hasMany(Payment::class, 'tenant_id');
    }

    // Un locataire a plusieurs tickets
    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'tenant_id');
    }

    // Un technicien a plusieurs tickets
    public function assignedTickets()
    {
        return $this->hasMany(Ticket::class, 'technician_id');
    }

    // Un gestionnaire a plusieurs abonnements
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    // Relation avec les appartements via tenant_apartment
    public function apartments()
    {
        return $this->belongsToMany(Apartment::class, 'tenant_apartments', 'tenant_id', 'apartment_id')
            ->withPivot('start_date', 'end_date');
    }
}
