
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('page-title', 'ImmoApp Admin') - ImmoApp</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-white shadow-md">
            <div class="p-6 border-b">
                <h1 class="text-2xl font-bold text-blue-600">ImmoApp</h1>
                <p class="text-sm text-gray-600">Gestion immobilière</p>
            </div>
            <nav class="mt-6">
                <a href="{{ route('admin.dashboard') }}" class="block px-6 py-3 text-gray-700 hover:bg-red-50 border-l-4 border-transparent hover:border-red-600 {{ request()->routeIs('admin.dashboard') ? 'bg-red-50 border-red-600' : '' }}">
                    <span class="font-medium">Tableau de bord</span>
                </a>
                <a href="{{ route('subscriptions.index') }}" class="block px-6 py-3 text-gray-700 hover:bg-red-50 border-l-4 border-transparent hover:border-red-600">
                    <span class="font-medium">Abonnements</span>
                </a>
                <a href="{{ route('admin.stats') }}" class="block px-6 py-3 text-gray-700 hover:bg-red-50 border-l-4 border-transparent hover:border-red-600">
                    <span class="font-medium">Statistiques</span>
                </a>
            </nav>
        </aside>
        <!-- Main Content -->
        <main class="flex-1">
            <div class="p-8">
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
