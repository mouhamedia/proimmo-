<?php
namespace App\Policies;

use App\Models\User;
use App\Models\Apartment;

class ApartmentPolicy
{
    public function view(User $user, Apartment $apartment)
    {
        return $user->residence_id === $apartment->building->residence_id;
    }

    public function update(User $user, Apartment $apartment)
    {
        return $user->role === 'manager' && $user->residence_id === $apartment->building->residence_id;
    }
}
