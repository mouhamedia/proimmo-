


<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AccessCodeController;
use App\Http\Controllers\ApartmentController;
use App\Http\Controllers\BuildingController;

// Page d'accueil
Route::get('/', function () {
    return view('welcome');
});

// Authentification
Route::get('/register', [App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [App\Http\Controllers\Auth\RegisterController::class, 'register']);
Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login']);
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->name('logout');

// Accès locataire/maintenancier par code
Route::get('/acces-code', [AccessCodeController::class, 'showForm'])->name('code.form');
Route::post('/acces-code', [AccessCodeController::class, 'submitCode'])->name('code.access');

// Gestion des immeubles (CRUD)
Route::resource('buildings', BuildingController::class);
Route::get('/buildings/{building}', [App\Http\Controllers\BuildingController::class, 'show'])->name('buildings.show');

// Gestion des appartements (CRUD)
Route::resource('apartments', ApartmentController::class);

// Gestion des appartements et dashboard pour le manager
Route::middleware(['auth'])->prefix('manager')->name('manager.')->group(function () {
    Route::resource('apartments', App\Http\Controllers\Manager\ApartmentController::class);
    Route::resource('buildings', App\Http\Controllers\Manager\BuildingController::class);
    Route::resource('tenants', App\Http\Controllers\Manager\TenantController::class);
    Route::resource('maintenance_workers', App\Http\Controllers\Manager\MaintenanceWorkerController::class);
    Route::get('dashboard', [App\Http\Controllers\Manager\DashboardController::class, 'index'])->name('dashboard');
});

// Dashboard (auth obligatoire)
Route::middleware(['auth'])->group(function() {
    Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    Route::post('/dashboard/verify-code', [\App\Http\Controllers\DashboardController::class, 'verifyCode'])->name('dashboard.verifyCode');
});
// Debug : affiche le token CSRF et la session
Route::get('/debug-csrf', function () {
    return [
        'csrf_token' => csrf_token(),
        'session_id' => session()->getId(),
        'all_data' => session()->all(),
        'has_cookie' => request()->hasCookie('laravel_session'),
        'cookies' => request()->cookies->all(),
    ];
})->middleware('web');

// Debug : force la création de la session et affiche le cookie
Route::get('/debug-session-set', function () {
    session(['test_key' => 'valeur_de_test']);
    return [
        'session_id' => session()->getId(),
        'all_data' => session()->all(),
        'has_cookie' => request()->hasCookie('laravel_session'),
        'cookies' => request()->cookies->all(),
    ];
})->middleware('web');

// Debug : force la création du cookie de session
Route::get('/test-cookie', function () {
    session(['cookie_test' => 'ok']);
    return response('Cookie de session forcé')->withCookie(cookie('laravel_session', session()->getId(), 120));
});

Route::get("/test-cookie", function() {
    session(["test" => "ok"]);
    return response("cookie test")->cookie("test_cookie", "hello", 60);
});

Route::get("/test-cookie", function() {
    session(["test" => "ok"]);
    return response("cookie test")->cookie("test_cookie", "hello", 60);
});
