<?php
namespace App\Services;

use App\Models\TenantApartment;

class TenantService
{
    public function assignTenant($tenantId, $apartmentId, $startDate)
    {
        return TenantApartment::create([
            'tenant_id' => $tenantId,
            'apartment_id' => $apartmentId,
            'start_date' => $startDate,
        ]);
    }
}
