<?php
namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;

class BuildingController extends Controller
{
    // Liste des immeubles
    public function index()
    {
        $manager = auth()->user();
        $residence = $manager->residence;
        $buildings = \App\Models\Building::where('residence_id', $residence->id)
            ->withCount('apartments')
            ->get();
        $apartments = \App\Models\Apartment::whereIn('building_id', $buildings->pluck('id'))->get();
        return view('manager.buildings.index', compact('buildings', 'apartments'));
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
        // Ajout d'une valeur par défaut si address n'est pas présent
        $validated['address'] = $request->input('address', '');
        \App\Models\Building::create($validated);
        return redirect()->route('manager.buildings.index')->with('success', 'Immeuble créé avec succès');
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
        return redirect()->route('manager.buildings.index')->with('success', 'Immeuble modifié avec succès');
    }

    // Supprime un immeuble
    public function destroy($id)
    {
        $building = \App\Models\Building::where('residence_id', \Auth::user()->residence_id)->findOrFail($id);
        $building->delete();
        return redirect()->route('manager.buildings.index')->with('success', 'Immeuble supprimé');
    }

    // Affiche la page d'un immeuble
    public function show($id)
    {
        $building = \App\Models\Building::where('residence_id', \Auth::user()->residence_id)->withCount('apartments')->findOrFail($id);
        return view('manager.buildings.show', compact('building'));
    }
}
