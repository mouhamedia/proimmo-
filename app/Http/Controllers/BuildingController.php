<?php

namespace App\Http\Controllers;

use App\Models\Building;
use Illuminate\Http\Request;

class BuildingController extends Controller
{
    public function index()
    {
        $residenceId = \Auth::user()->residence_id;
        $buildings = Building::where('residence_id', $residenceId)->get();
        return view('buildings.index', compact('buildings'));
    }

    public function create()
    {
        return view('buildings.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'address' => 'required',
            'floors' => 'required|integer|min:1',
        ]);
        $data = $request->only('name', 'address', 'floors');
        $data['residence_id'] = \Auth::user()->residence_id;
        // On suppose que la résidence existe déjà (créée à la création de l'utilisateur)
        Building::create($data);
        return redirect()->route('buildings.index')->with('success', 'Immeuble créé avec succès');
    }

    public function show(Building $building)
    {
        $building->load('apartments');
        $apartments = $building->apartments;
        $building->apartments_count = $apartments->count();
        $building->occupied_count = $apartments->where('status', 'occupé')->count();
        $building->vacant_count = $apartments->where('status', 'vacant')->count();
        $building->work_count = $apartments->where('status', 'en travaux')->count();
        $building->total_rent = $apartments->sum('rent_amount');
        $building->average_rent = $apartments->count() ? round($apartments->avg('rent_amount')) : 0;
        $building->occupation_rate = $building->apartments_count ? round($building->occupied_count / $building->apartments_count * 100) : 0;
        return view('manager.buildings.show', compact('building'));
    }

    public function edit(Building $building)
    {
        // Suppression du blocage d'accès pour la résidence (aucun abort 403)
        return view('buildings.edit', compact('building'));
    }

    public function update(Request $request, Building $building)
    {
        if ($building->residence_id !== \Auth::user()->residence_id) {
            // Blocage supprimé : accès autorisé même si la résidence ne correspond pas
        }
        $request->validate([
            'name' => 'required',
            'address' => 'required',
            'floors' => 'required|integer|min=1',
        ]);
        $building->update($request->only('name', 'address', 'floors'));
        return redirect()->route('buildings.index')->with('success', 'Immeuble modifié avec succès');
    }

    public function destroy(Building $building)
    {
        if ($building->residence_id !== \Auth::user()->residence_id) {
            // Blocage supprimé : accès autorisé même si la résidence ne correspond pas
        }
        $building->delete();
        return redirect()->route('buildings.index')->with('success', 'Immeuble supprimé avec succès');
    }
}
