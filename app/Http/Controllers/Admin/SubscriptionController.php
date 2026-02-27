<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class SubscriptionController extends Controller
{
    // Liste des abonnements
    public function index()
    {
        $subscriptions = \App\Models\Subscription::with('user', 'plan')->get();
        return view('admin.subscriptions', compact('subscriptions'));
    }

    // Affiche un abonnement
    public function show($id)
    {
        $subscription = \App\Models\Subscription::with('user', 'plan')->findOrFail($id);
        return view('admin.subscription_show', compact('subscription'));
    }

    // Met à jour un abonnement
    public function update(\Illuminate\Http\Request $request, $id)
    {
        $subscription = \App\Models\Subscription::findOrFail($id);
        $subscription->update($request->only(['status', 'end_date']));
        return redirect()->route('subscriptions.index')->with('success', 'Abonnement mis à jour');
    }

    // Supprime un abonnement
    public function destroy($id)
    {
        $subscription = \App\Models\Subscription::findOrFail($id);
        $subscription->delete();
        return redirect()->route('subscriptions.index')->with('success', 'Abonnement supprimé');
    }
}
