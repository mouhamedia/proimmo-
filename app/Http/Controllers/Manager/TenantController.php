<?php
namespace App\Http\Controllers\Manager;
use App\Http\Controllers\Controller;

class TenantController extends Controller
{
    // Affiche la fiche détaillée d'un locataire
    public function show($id)
    {
        $residenceId = \Auth::user()->residence_id;
        $tenant = \App\Models\User::where('role', 'tenant')->where('residence_id', $residenceId)->findOrFail($id);
        $tenant->load('payments');
        return view('manager.tenants.show', compact('tenant'));
    }
    // Liste des locataires
    public function index()
    {
        $residenceId = \Auth::user()->residence_id;
        $tenants = \App\Models\User::where('role', 'tenant')->where('residence_id', $residenceId)->get();
        return view('manager.tenants.index', compact('tenants'));
    }

    // Formulaire création
    public function create()
    {
        $apartments = \App\Models\Apartment::whereHas('building', function($q) {
            $q->where('residence_id', \Auth::user()->residence_id);
        })
        ->where('status', 'vacant')
        ->get();
        return view('manager.tenants.create', compact('apartments'));
    }

    // Enregistre un locataire
    public function store(\App\Http\Requests\StoreTenantRequest $request)
    {
        $validated = $request->validated();
        $validated['role'] = 'tenant';
        $validated['residence_id'] = \Auth::user()->residence_id;
        if (!empty($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        } else {
            // Génère un mot de passe fort aléatoire si non fourni
            $randomPassword = bin2hex(random_bytes(6));
            $validated['password'] = bcrypt($randomPassword);
        }
        $tenant = \App\Models\User::create($validated);
        // Assignation à l'appartement
        \App\Models\TenantApartment::create([
            'tenant_id' => $tenant->id,
            'apartment_id' => $validated['apartment_id'],
            'start_date' => now(),
        ]);
        // Met à jour le statut de l'appartement
        $apartment = \App\Models\Apartment::find($validated['apartment_id']);
        if ($apartment) {
            $apartment->status = 'occupé';
            $apartment->save();
            \Log::info('Assignation appartement', [
                'apartment_id' => $apartment->id,
                'status_apres_save' => $apartment->status
            ]);
        }
        return redirect()->route('manager.tenants.index')->with('success', 'Locataire créé et assigné');
    }

    // Formulaire édition
    public function edit($id)
    {
        $residenceId = \Auth::user()->residence_id;
        $tenant = \App\Models\User::where('role', 'tenant')->where('residence_id', $residenceId)->findOrFail($id);
        $apartments = \App\Models\Apartment::whereHas('building', function($q) {
            $q->where('residence_id', \Auth::user()->residence_id);
        })->get();
        return view('manager.tenants.edit', compact('tenant', 'apartments'));
    }

    // Met à jour un locataire
    public function update(\App\Http\Requests\StoreTenantRequest $request, $id)
    {
        $residenceId = \Auth::user()->residence_id;
        $tenant = \App\Models\User::where('role', 'tenant')->where('residence_id', $residenceId)->findOrFail($id);
        $tenant->update($request->validated());
        return redirect()->route('tenants.index')->with('success', 'Locataire modifié');
    }

    // Supprime un locataire
    public function destroy($id)
    {
        $residenceId = \Auth::user()->residence_id;
        $tenant = \App\Models\User::where('role', 'tenant')->where('residence_id', $residenceId)->findOrFail($id);
        // On récupère tous les appartements liés avant suppression
        $apartments = $tenant->apartments;
        $tenant->delete();
        // Pour chaque appartement, vérifier s'il reste un locataire actif
        foreach ($apartments as $apartment) {
            if (!$apartment->tenants()->wherePivot('end_date', null)->exists()) {
                $apartment->status = 'vacant';
                $apartment->save();
            }
        }
        return redirect()->route('manager.tenants.index')->with('success', 'Locataire supprimé');
    }

    // Assigne un locataire à un appartement
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
        ]);
        // Met à jour le statut de l'appartement
            $apartment->status = 'occupé';
        $apartment->save();
        return redirect()->route('tenants.index')->with('success', 'Locataire assigné à l\'appartement');
    }
}
