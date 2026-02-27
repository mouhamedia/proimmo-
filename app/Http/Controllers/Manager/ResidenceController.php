<?php
namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;

class ResidenceController extends Controller
{
    // Liste des résidences (uniquement celles du manager)
    public function index()
    {
        $userId = \Auth::id();
        $residences = \App\Models\Residence::where('owner_id', $userId)->get();
        return view('manager.residences.index', compact('residences'));
    }

    // Formulaire création
    public function create()
    {
        return view('manager.residences.create');
    }

    // Enregistre une résidence
    public function store(\App\Http\Requests\StoreResidenceRequest $request)
    {
        $validated = $request->validated();
        $validated['owner_id'] = \Auth::id();
        \App\Models\Residence::create($validated);
        return redirect()->route('residences.index')->with('success', 'Résidence créée avec succès');
    }

    // Formulaire édition
    public function edit($id)
    {
        $residence = \App\Models\Residence::where('owner_id', \Auth::id())->findOrFail($id);
        return view('manager.residences.edit', compact('residence'));
    }

    // Met à jour une résidence
    public function update(\App\Http\Requests\StoreResidenceRequest $request, $id)
    {
        $residence = \App\Models\Residence::where('owner_id', \Auth::id())->findOrFail($id);
        $residence->update($request->validated());
        return redirect()->route('residences.index')->with('success', 'Résidence modifiée');
    }

    // Supprime une résidence
    public function destroy($id)
    {
        $residence = \App\Models\Residence::where('owner_id', \Auth::id())->findOrFail($id);
        $residence->delete();
        return redirect()->route('residences.index')->with('success', 'Résidence supprimée');
    }
}
