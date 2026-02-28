<?php
namespace App\Http\Controllers\Manager;
use App\Http\Controllers\Controller;

class TenantController extends Controller
{
    public function show($id)
    {
        $residenceId = \Auth::user()->residence_id;
        $tenant = \App\Models\User::where('role', 'tenant')->where('residence_id', $residenceId)->findOrFail($id);
        $tenant->load('payments');
        return view('manager.tenants.show', compact('tenant'));
    }

    public function index()
    {
        $residenceId = \Auth::user()->residence_id;
        $tenants = \App\Models\User::where('role', 'tenant')->where('residence_id', $residenceId)->get();
        return view('manager.tenants.index', compact('tenants'));
    }

    public function create()
    {
        $apartments = \App\Models\Apartment::whereHas('building', function($q) {
            $q->where('residence_id', \Auth::user()->residence_id);
        })->where('status', 'vacant')->get();
        return view('manager.tenants.create', compact('apartments'));
    }

    public function store(\App\Http\Requests\StoreTenantRequest $request)
    {
        $validated = $request->validated();
        $validated['role'] = 'tenant';
        $validated['residence_id'] = \Auth::user()->residence_id;
        if (!empty($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        } else {
            $validated['password'] = bcrypt(bin2hex(random_bytes(6)));
        }
        $tenant = \App\Models\User::create($validated);
        \App\Models\TenantApartment::create([
            'tenant_id' => $tenant->id,
            'apartment_id' => $validated['apartment_id'],
            'start_date' => now(),
            'code' => strtoupper(bin2hex(random_bytes(4))),
        ]);
        $apartment = \App\Models\Apartment::find($validated['apartment_id']);
        if ($apartment) {
            $apartment->status = 'occupé';
            $apartment->save();
        }
        return redirect()->route('manager.tenants.index')->with('success', 'Locataire créé et assigné');
    }

    public function edit($id)
    {
        $residenceId = \Auth::user()->residence_id;
        $tenant = \App\Models\User::where('role', 'tenant')->where('residence_id', $residenceId)->findOrFail($id);
        $apartments = \App\Models\Apartment::whereHas('building', function($q) {
            $q->where('residence_id', \Auth::user()->residence_id);
        })->get();
        return view('manager.tenants.edit', compact('tenant', 'apartments'));
    }

    public function update(\App\Http\Requests\StoreTenantRequest $request, $id)
    {
        $residenceId = \Auth::user()->residence_id;
        $tenant = \App\Models\User::where('role', 'tenant')->where('residence_id', $residenceId)->findOrFail($id);
        $tenant->update($request->validated());
        return redirect()->route('manager.tenants.index')->with('success', 'Locataire modifié');
    }

    public function destroy($id)
    {
        $residenceId = \Auth::user()->residence_id;
        $tenant = \App\Models\User::where('role', 'tenant')->where('residence_id', $residenceId)->findOrFail($id);
        $apartments = $tenant->apartments;
        $tenant->delete();
        foreach ($apartments as $apartment) {
            if (!$apartment->tenants()->wherePivot('end_date', null)->exists()) {
                $apartment->status = 'vacant';
                $apartment->save();
            }
        }
        return redirect()->route('manager.tenants.index')->with('success', 'Locataire supprimé');
    }

    public function assign($tenantId, $apartmentId)
    {
        $tenant = \App\Models\User::where('role', 'tenant')->where('residence_id', \Auth::user()->residence_id)->findOrFail($tenantId);
        $apartment = \App\Models\Apartment::whereHas('building', function($q) {
            $q->where('residence_id', \Auth::user()->residence_id);
        })->findOrFail($apartmentId);
        \App\Models\TenantApartment::create([
            'tenant_id' => $tenant->id,
            'apartment_id' => $apartment->id,
            'start_date' => now(),
            'code' => strtoupper(bin2hex(random_bytes(4))),
        ]);
        $apartment->status = 'occupé';
        $apartment->save();
        return redirect()->route('manager.tenants.index')->with('success', 'Locataire assigné');
    }
}
