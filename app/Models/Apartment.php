<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Apartment extends Model
{
    protected $fillable = [
        'building_id', 'number', 'type', 'rent_amount', 'status', 'access_code', 'tenant_id'
    ];

    // Génération automatique du code d'accès unique à la création
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($apartment) {
            if (empty($apartment->access_code)) {
                $apartment->access_code = strtoupper(bin2hex(random_bytes(4)));
            }
        });
    }

    // Relation avec le bâtiment
    public function building()
    {
        return $this->belongsTo(Building::class);
    }

    // Relation avec les espaces
    public function spaces()
    {
        return $this->hasMany(Space::class);
    }

    // Relation avec les locataires (via tenant_apartment)
    public function tenants()
    {
        return $this->belongsToMany(User::class, 'tenant_apartments', 'apartment_id', 'tenant_id')
            ->withPivot('start_date', 'end_date');
    }

    // Paiements
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    // Tickets
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
