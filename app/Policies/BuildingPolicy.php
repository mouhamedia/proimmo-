<?php
namespace App\Policies;

use App\Models\User;
use App\Models\Building;

class BuildingPolicy
{
    public function view(User $user, Building $building)
    {
        return $user->residence_id === $building->residence_id;
    }

    public function update(User $user, Building $building)
    {
        return $user->role === 'manager' && $user->residence_id === $building->residence_id;
    }
}
