<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Building extends Model
{
    protected $fillable = [
        'residence_id', 'name', 'address', 'floors'
    ];

    // Relation avec la résidence
    public function residence()
    {
        return $this->belongsTo(Residence::class);
    }

    // Relation avec les appartements
    public function apartments()
    {
        return $this->hasMany(Apartment::class);
    }
}
