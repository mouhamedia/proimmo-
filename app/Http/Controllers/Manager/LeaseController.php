<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use Illuminate\Support\Facades\Auth;

class LeaseController extends Controller
{
    public function index()
    {
        $currentUser = Auth::user();

        $leases = Subscription::with(['user', 'plan'])
            ->orderByDesc('start_date')
            ->orderByDesc('id')
            ->get();

        $activeCount = $leases->where('status', 'active')->count();
        $expiredCount = $leases->where('status', 'expired')->count();
        $totalCount = $leases->count();

        $myLease = $leases->firstWhere('user_id', $currentUser->id);

        return view('manager.leases.index', compact(
            'leases',
            'activeCount',
            'expiredCount',
            'totalCount',
            'myLease'
        ));
    }
}