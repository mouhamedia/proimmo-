
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('page-title', 'ImmoApp Admin') - ImmoApp</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <style>
        .admin-shell { min-height: 100vh; display: flex; }
        .admin-sidebar { width: 16rem; background: #fff; box-shadow: 0 1px 2px rgba(0,0,0,0.05); }
        .admin-content { flex: 1; min-width: 0; }
        .admin-main { padding: 2rem; }
        .admin-nav-link { display: block; padding: 0.75rem 1.5rem; color: #374151; border-left: 4px solid transparent; }
        .admin-nav-link:hover { background: #fef2f2; border-left-color: #dc2626; }
        .admin-nav-link.active { background: #fef2f2; border-left-color: #dc2626; }
        @media (max-width: 900px) {
            .admin-shell { flex-direction: column; }
            .admin-sidebar { width: 100%; }
            .admin-main { padding: 1rem; }
        }
    </style>
    <div class="admin-shell">
        <!-- Sidebar -->
        <aside class="admin-sidebar">
            <div class="p-6 border-b">
                <h1 class="text-2xl font-bold text-blue-600">ImmoApp</h1>
                <p class="text-sm text-gray-600">Gestion immobilière</p>
            </div>
            <nav class="mt-6">
                <a href="{{ route('admin.dashboard') }}" class="admin-nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <span class="font-medium">Tableau de bord</span>
                </a>
                <a href="{{ route('subscriptions.index') }}" class="admin-nav-link">
                    <span class="font-medium">Abonnements</span>
                </a>
                <a href="{{ route('admin.stats') }}" class="admin-nav-link">
                    <span class="font-medium">Statistiques</span>
                </a>
                <a href="{{ Route::has('messages.index') ? route('messages.index') : '#' }}" class="admin-nav-link {{ request()->routeIs('messages.*') ? 'active' : '' }}">
                    <span class="font-medium">Messagerie</span>
                </a>
            </nav>
        </aside>
        <!-- Main Content -->
        <main class="admin-content">
            <div class="admin-main">
                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                        <h3 class="font-bold mb-2">Erreurs de validation</h3>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('success'))
                    <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                @section('content')
                    @show
            </div>
        </main>
    </div>
</body>
</html>
