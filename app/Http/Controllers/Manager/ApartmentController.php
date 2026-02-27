<?php
namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;

class ApartmentController extends Controller
{
    // Liste des appartements
    public function index()
    {
        $residenceId = \Auth::user()->residence_id;
        $apartments = \App\Models\Apartment::whereHas('building', function($q) use ($residenceId) {
            $q->where('residence_id', $residenceId);
        })->with('building')->get();
        return view('manager.apartments.index', compact('apartments'));
    }

    // Formulaire création
    public function create()
    {
        $residenceId = \Auth::user()->residence_id;
        $buildings = \App\Models\Building::where('residence_id', $residenceId)->get();
        return view('manager.apartments.create', compact('buildings'));
    }

    // Enregistre un appartement
    public function store(\App\Http\Requests\StoreApartmentRequest $request)
    {
        $validated = $request->validated();
        $building = \App\Models\Building::where('residence_id', \Auth::user()->residence_id)
            ->findOrFail($validated['building_id']);
        $validated['building_id'] = $building->id;
        \App\Models\Apartment::create($validated);
        return redirect()->route('manager.apartments.index')->with('success', 'Appartement créé');
    }

    // Formulaire édition
    public function edit($id)
    {
        $residenceId = \Auth::user()->residence_id;
        $apartment = \App\Models\Apartment::whereHas('building', function($q) use ($residenceId) {
            $q->where('residence_id', $residenceId);
        })->findOrFail($id);
        $buildings = \App\Models\Building::where('residence_id', $residenceId)->get();
        return view('manager.apartments.edit', compact('apartment', 'buildings'));
    }

    // Met à jour un appartement
    public function update(\App\Http\Requests\StoreApartmentRequest $request, $id)
    {
        $residenceId = \Auth::user()->residence_id;
        $apartment = \App\Models\Apartment::whereHas('building', function($q) use ($residenceId) {
            $q->where('residence_id', $residenceId);
        })->findOrFail($id);
        $validated = $request->validated();
        $apartment->update($validated);
        return redirect()->route('apartments.index')->with('success', 'Appartement modifié');
    }

    // Supprime un appartement
    public function destroy($id)
    {
        $residenceId = \Auth::user()->residence_id;
        $apartment = \App\Models\Apartment::whereHas('building', function($q) use ($residenceId) {
            $q->where('residence_id', $residenceId);
        })->findOrFail($id);
        $apartment->delete();
        return redirect()->route('apartments.index')->with('success', 'Appartement supprimé');
    }
}
