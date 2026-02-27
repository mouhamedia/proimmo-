<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TenantApartment extends Model
{
    protected $fillable = [
        'tenant_id', 'apartment_id', 'start_date', 'end_date', 'code'
    ];

    public function tenant()
    {
        return $this->belongsTo(User::class, 'tenant_id');
    }

    public function apartment()
    {
        return $this->belongsTo(Apartment::class);
    }
}
