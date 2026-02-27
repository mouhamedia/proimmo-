<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('page-title', 'ImmoApp') — ImmoApp</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --sidebar-w: 260px;
            --gold: #C9A96E;
            --gold-light: #E8D5B0;
            --dark: #1A1A2E;
            --dark-2: #16213E;
            --dark-3: #0F3460;
            --text-muted: #8B8FA8;
            --surface: #F8F7F5;
            --white: #FFFFFF;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--surface);
            color: var(--dark);
            min-height: 100vh;
            display: flex;
        }

        /* ─── SIDEBAR ─────────────────────────────────────── */
        .sidebar {
            width: var(--sidebar-w);
            min-height: 100vh;
            background: var(--dark);
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
            position: fixed;
            top: 0; left: 0;
            z-index: 100;
            overflow: hidden;
        }

        .sidebar::before {
            content: '';
            position: absolute;
            top: -80px; right: -80px;
            width: 220px; height: 220px;
            background: var(--gold);
            opacity: 0.07;
            border-radius: 50%;
            pointer-events: none;
        }

        /* Brand */
        .sidebar-brand {
            padding: 32px 28px 24px;
            border-bottom: 1px solid rgba(255,255,255,0.06);
            position: relative;
        }

        .brand-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 4px;
        }

        .brand-icon {
            width: 36px; height: 36px;
            background: var(--gold);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }

        .brand-name {
            font-family: 'Playfair Display', serif;
            font-size: 22px;
            font-weight: 600;
            color: var(--white);
            letter-spacing: 0.5px;
        }

        .brand-tagline {
            font-size: 11px;
            font-weight: 300;
            color: var(--text-muted);
            letter-spacing: 2px;
            text-transform: uppercase;
            padding-left: 46px;
        }

        /* Nav */
        .sidebar-nav {
            padding: 20px 16px;
            flex: 1;
        }

        .nav-section-label {
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 2.5px;
            text-transform: uppercase;
            color: var(--text-muted);
            padding: 16px 12px 8px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 12px;
            border-radius: 10px;
            text-decoration: none;
            color: rgba(255,255,255,0.55);
            font-size: 14px;
            font-weight: 400;
            margin-bottom: 2px;
            transition: all 0.2s ease;
            position: relative;
        }

        .nav-item:hover {
            background: rgba(255,255,255,0.05);
            color: var(--white);
        }

        .nav-item.active {
            background: rgba(201,169,110,0.15);
            color: var(--gold-light);
        }

        .nav-item.active::before {
            content: '';
            position: absolute;
            left: 0; top: 50%;
            transform: translateY(-50%);
            width: 3px; height: 60%;
            background: var(--gold);
            border-radius: 0 4px 4px 0;
        }

        .nav-icon {
            width: 20px; height: 20px;
            opacity: 0.7;
            flex-shrink: 0;
        }

        .nav-item.active .nav-icon,
        .nav-item:hover .nav-icon {
            opacity: 1;
        }

        .nav-badge {
            margin-left: auto;
            background: var(--gold);
            color: var(--dark);
            font-size: 10px;
            font-weight: 600;
            padding: 2px 7px;
            border-radius: 20px;
        }

        /* User section */
        .sidebar-user {
            padding: 16px;
            border-top: 1px solid rgba(255,255,255,0.06);
        }

        .user-card {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 12px;
            border-radius: 10px;
            cursor: pointer;
            transition: background 0.2s;
        }

        .user-card:hover { background: rgba(255,255,255,0.05); }

        .user-avatar {
            width: 36px; height: 36px;
            background: linear-gradient(135deg, var(--gold), #E8A455);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            font-weight: 600;
            color: var(--dark);
            flex-shrink: 0;
        }

        .user-info { flex: 1; min-width: 0; }

        .user-name {
            font-size: 13px;
            font-weight: 500;
            color: var(--white);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .user-role {
            font-size: 11px;
            color: var(--text-muted);
        }

        /* ─── MAIN ─────────────────────────────────────────── */
        .main-wrapper {
            margin-left: var(--sidebar-w);
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Top bar */
        .topbar {
            background: var(--white);
            border-bottom: 1px solid #EEECEA;
            padding: 0 32px;
            height: 64px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .page-title-bar {
            font-family: 'Playfair Display', serif;
            font-size: 20px;
            font-weight: 600;
            color: var(--dark);
        }

        .breadcrumb {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            color: var(--text-muted);
        }

        .breadcrumb span { color: var(--dark); }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .topbar-btn {
            width: 38px; height: 38px;
            border-radius: 10px;
            border: 1px solid #EEECEA;
            background: transparent;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-muted);
            transition: all 0.2s;
            position: relative;
        }

        .topbar-btn:hover {
            background: var(--surface);
            color: var(--dark);
        }

        .notif-dot {
            position: absolute;
            top: 8px; right: 8px;
            width: 7px; height: 7px;
            background: var(--gold);
            border-radius: 50%;
            border: 2px solid var(--white);
        }

        /* Page content */
        .page-content {
            padding: 32px;
            flex: 1;
        }

        /* ─── RESPONSIVE ───────────────────────────────────── */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }

            .sidebar.open { transform: translateX(0); }

            .main-wrapper { margin-left: 0; }

            .page-content { padding: 20px 16px; }

            .topbar { padding: 0 16px; }

            .mobile-menu-btn { display: flex !important; }
        }

        .mobile-menu-btn { display: none; }

        /* ─── SCROLLBAR ────────────────────────────────────── */
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #D4CDC6; border-radius: 10px; }
    </style>
</head>
<body>

    <!-- ════════ SIDEBAR ════════ -->
    <aside class="sidebar" id="sidebar">

        <div class="sidebar-brand">
            <div class="brand-logo">
                <div class="brand-icon">🏛</div>
                <span class="brand-name">ImmoApp</span>
            </div>
            <div class="brand-tagline">Gestion immobilière</div>
        </div>

        <nav class="sidebar-nav">

            @if(Route::has('code.form'))
            <a href="{{ route('code.form') }}" class="nav-item" style="display:flex;align-items:center;justify-content:center;gap:10px;margin:16px 16px 4px;width:calc(100% - 32px);background:#C9A96E;color:#1A1A2E;padding:12px 0;border-radius:8px;font-size:13px;font-weight:700;text-decoration:none;">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M12 4v16m8-8H4"/></svg>
                Accès locataire / maintenancier
            </a>
            @endif

            <div class="nav-section-label">Principal</div>

            <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Tableau de bord
            </a>


            <div class="nav-section-label">Portefeuille</div>

            <a href="{{ Route::has('buildings.index') ? route('buildings.index') : '#' }}" class="nav-item {{ request()->routeIs('buildings.*') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 10V6a2 2 0 012-2h12a2 2 0 012 2v4" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 22V12m-8 8h16a2 2 0 002-2V10a2 2 0 00-2-2H4a2 2 0 00-2 2v8a2 2 0 002 2z" />
                </svg>
                Immeubles
            </a>

            <a href="{{ Route::has('manager.apartments.index') ? route('manager.apartments.index') : '#' }}" class="nav-item {{ request()->routeIs('manager.apartments.*') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V7" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 3v4M8 3v4M4 11h16" />
                </svg>
                Appartements (manager)
            </a>

            <a href="{{ Route::has('properties.index') ? route('properties.index') : '#' }}" class="nav-item {{ request()->routeIs('properties.*') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
                Propriétés
                <span class="nav-badge">24</span>
            </a>

            <a href="{{ Route::has('manager.tenants.index') ? route('manager.tenants.index') : '#' }}" class="nav-item {{ request()->routeIs('manager.tenants.*') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                Locataires
            </a>

            <a href="{{ Route::has('leases.index') ? route('leases.index') : '#' }}" class="nav-item {{ request()->routeIs('leases.*') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Baux
            </a>

            <div class="nav-section-label">Finance</div>

            <a href="{{ Route::has('payments.index') ? route('payments.index') : '#' }}" class="nav-item {{ request()->routeIs('payments.*') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                        d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                </svg>
                Paiements
                <span class="nav-badge">3</span>
            </a>

            <a href="{{ Route::has('reports.index') ? route('reports.index') : '#' }}" class="nav-item {{ request()->routeIs('reports.*') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                Rapports
            </a>

            <div class="nav-section-label">Système</div>

            <a href="{{ Route::has('settings.index') ? route('settings.index') : '#' }}" class="nav-item {{ request()->routeIs('settings.*') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                Paramètres
            </a>
        </nav>

        <div class="sidebar-user">
            <div class="user-card">
                <div class="user-avatar">
                    {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                </div>
                <div class="user-info">
                    <div class="user-name">{{ auth()->user()->name ?? 'Utilisateur' }}</div>
                    <div class="user-role">Administrateur</div>
                </div>
                <svg width="16" height="16" fill="none" stroke="#8B8FA8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </div>
        </div>
    </aside>

    <!-- ════════ MAIN ════════ -->
    <div class="main-wrapper">

        <!-- Top bar -->
        <header class="topbar">
            <div class="topbar-left">
                <!-- Mobile menu toggle -->
                <button class="topbar-btn mobile-menu-btn" id="menuToggle" style="display:none">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>

                <div>
                    <div class="page-title-bar">@yield('page-title', 'Tableau de bord')</div>
                    <div class="breadcrumb">
                        @yield('breadcrumb', '<span>Accueil</span>')
                    </div>
                </div>
            </div>

            <div class="topbar-right">
                <!-- Search -->
                <button class="topbar-btn" title="Rechercher">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </button>

                <!-- Notifications -->
                <button class="topbar-btn" title="Notifications">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                    <div class="notif-dot"></div>
                </button>

                <!-- Logout -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="topbar-btn" title="Se déconnecter">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                    </button>
                </form>
            </div>
        </header>

        <!-- Page content -->
        <main class="page-content">
            @if(session('success'))
                <div style="background:#F0FDF4;border:1px solid #BBF7D0;color:#15803D;padding:12px 16px;border-radius:10px;margin-bottom:20px;font-size:14px;display:flex;align-items:center;gap:8px;">
                    ✓ {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div style="background:#FEF2F2;border:1px solid #FECACA;color:#DC2626;padding:12px 16px;border-radius:10px;margin-bottom:20px;font-size:14px;display:flex;align-items:center;gap:8px;">
                    ✕ {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <script>
        // Mobile sidebar toggle
        const sidebar = document.getElementById('sidebar');
        const menuToggle = document.getElementById('menuToggle');
        if (menuToggle) {
            menuToggle.addEventListener('click', () => {
                sidebar.classList.toggle('open');
            });
        }
    </script>

</body>
</html>