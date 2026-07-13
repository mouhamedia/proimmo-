<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AccessCodeController;
use App\Http\Controllers\MessageController;

// Page d'accueil
Route::get('/', function () {
    return view('welcome');
});

// Authentification
Route::get('/register', [App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [App\Http\Controllers\Auth\RegisterController::class, 'register']);
Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login']);
Route::get('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
});
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->name('logout');

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

// Accès locataire/maintenancier par code
Route::get('/acces-code', [AccessCodeController::class, 'showForm'])->name('code.form');
Route::post('/acces-code', [AccessCodeController::class, 'submitCode'])->name('code.access');

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

// Connexion par code d'accès (locataire/maintenancier)
Route::get('code-login', function() {
    return view('auth.code_login');
})->name('code.login.view');
Route::post('code-login', [App\Http\Controllers\Auth\CodeLoginController::class, 'login'])->name('code.login.submit');

Route::middleware(['auth'])->group(function () {
    Route::get('/messages/{user?}', [MessageController::class, 'index'])->name('messages.index');
    Route::post('/messages', [MessageController::class, 'store'])->name('messages.store');
});

