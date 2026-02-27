<?php
namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    // Vue locataire
    public function index()
    {
           return view('tenant.dashboard');
    }
}
