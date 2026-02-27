<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = [
        'apartment_id', 'technician_id', 'description', 'status'
    ];

    public function apartment()
    {
        return $this->belongsTo(Apartment::class);
    }



    public function technician()
    {
        return $this->belongsTo(Technician::class);
    }
}
