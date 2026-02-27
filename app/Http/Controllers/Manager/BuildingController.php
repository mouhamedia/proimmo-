<?php
namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;

class BuildingController extends Controller
{
    // Liste des immeubles
    public function index()
    {
        $residenceId = \Auth::user()->residence_id;
        $buildings = \App\Models\Building::where('residence_id', $residenceId)->get();
        return view('manager.buildings.index', compact('buildings'));
    }

    // Formulaire création
    public function create()
    {
        return view('manager.buildings.create');
    }

    // Enregistre un immeuble
    public function store(\App\Http\Requests\StoreBuildingRequest $request)
    {
        $validated = $request->validated();
        $validated['residence_id'] = \Auth::user()->residence_id;
        \App\Models\Building::create($validated);
        return redirect()->route('buildings.index')->with('success', 'Immeuble créé avec succès');
    }

    // Formulaire édition
    public function edit($id)
    {
        $building = \App\Models\Building::where('residence_id', \Auth::user()->residence_id)->findOrFail($id);
        return view('manager.buildings.edit', compact('building'));
    }

    // Met à jour un immeuble
    public function update(\App\Http\Requests\StoreBuildingRequest $request, $id)
    {
        $building = \App\Models\Building::where('residence_id', \Auth::user()->residence_id)->findOrFail($id);
        $building->update($request->validated());
        return redirect()->route('buildings.index')->with('success', 'Immeuble modifié avec succès');
    }

    // Supprime un immeuble
    public function destroy($id)
    {
        $building = \App\Models\Building::where('residence_id', \Auth::user()->residence_id)->findOrFail($id);
        $building->delete();
        return redirect()->route('buildings.index')->with('success', 'Immeuble supprimé');
    }
}
