<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Residence extends Model
{
    //
    protected $fillable = [
        'name', 'address', 'owner_id'
    ];

    // Relation avec le gestionnaire (owner)
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    // Relation avec les bâtiments
    public function buildings()
    {
        return $this->hasMany(Building::class);
    }

    // Relation avec les utilisateurs
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
