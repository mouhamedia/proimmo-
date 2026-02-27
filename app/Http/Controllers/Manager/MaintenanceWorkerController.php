<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class MaintenanceWorkerController extends Controller
{
    public function index()
    {
        $residenceId = \Auth::user()->residence_id;
        $workers = User::where('role', 'maintenance')->where('residence_id', $residenceId)->get();
        return view('manager.maintenance_workers.index', compact('workers'));
    }

    public function create()
    {
        return view('manager.maintenance_workers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);
        $validated['role'] = 'maintenance';
        $validated['residence_id'] = \Auth::user()->residence_id;
        $validated['password'] = bcrypt($validated['password']);
        User::create($validated);
        return redirect()->route('manager.maintenance_workers.index')->with('success', 'Maintenancier créé');
    }

    public function edit($id)
    {
        $worker = User::findOrFail($id);
        return view('manager.maintenance_workers.edit', compact('worker'));
    }

    public function update(Request $request, $id)
    {
        $worker = User::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $worker->id,
        ]);
        $worker->update($validated);
        return redirect()->route('manager.maintenance_workers.index')->with('success', 'Maintenancier modifié');
    }

    public function destroy($id)
    {
        $worker = User::findOrFail($id);
        $worker->delete();
        return redirect()->route('manager.maintenance_workers.index')->with('success', 'Maintenancier supprimé');
    }
}
