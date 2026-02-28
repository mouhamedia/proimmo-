<?php

namespace App\Http\Controllers;

use App\Models\Building;
use Illuminate\Http\Request;

class BuildingController extends Controller
{
    public function index()
    {
        $residenceId = \Auth::user()->residence_id;
           // Pagination pour éviter de charger trop d'immeubles en mémoire
           $buildings = Building::where('residence_id', $residenceId)->paginate(20);
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

        $user = \Auth::user();

        // Créer une résidence si l'utilisateur n'en a pas
        if (!$user->residence_id) {
            $residence = \App\Models\Residence::create([
                'name' => $user->name . ' - Résidence',
                'manager_id' => $user->id,
                'address' => 'Adresse inconnue', // Ajout d'une adresse par défaut
            ]);
            $user->update(['residence_id' => $residence->id]);
            $user->refresh();
        }

        // Vérification finale que residence_id est bien présent
        if (!$user->residence_id) {
            return redirect()->back()->withErrors(['residence_id' => "Impossible d'associer une résidence à l'utilisateur."]);
        }

        $data = $request->only('name', 'address', 'floors');
        $data['residence_id'] = $user->residence_id;

        Building::create($data);

        return redirect()->route('buildings.index')->with('success', 'Immeuble créé avec succès');
    }

    public function show(Building $building)
    {
           // Optimisation : calculs SQL pour éviter de charger tous les appartements en mémoire
           $apartments_count = $building->apartments()->count();
           $occupied_count = $building->apartments()->where('status', 'occupé')->count();
           $vacant_count = $building->apartments()->where('status', 'vacant')->count();
           $work_count = $building->apartments()->where('status', 'en travaux')->count();
           $total_rent = $building->apartments()->sum('rent_amount');
           $average_rent = $apartments_count ? round($building->apartments()->avg('rent_amount')) : 0;
           $occupation_rate = $apartments_count ? round($occupied_count / $apartments_count * 100) : 0;

           // On charge uniquement les appartements nécessaires (pagination possible si besoin)
           $apartments = $building->apartments()->get();

           // On passe les statistiques à la vue
           $building->apartments_count = $apartments_count;
           $building->occupied_count = $occupied_count;
           $building->vacant_count = $vacant_count;
           $building->work_count = $work_count;
           $building->total_rent = $total_rent;
           $building->average_rent = $average_rent;
           $building->occupation_rate = $occupation_rate;
           $building->setRelation('apartments', $apartments);
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
