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
            --text-muted: #8B8FA8;
            --surface: #F8F7F5;
            --white: #FFFFFF;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        /* ─── LAYOUT ROOT ─────────────────────────────────── */
        html, body {
            height: 100%;
            font-family: 'DM Sans', sans-serif;
            background: var(--surface);
            color: var(--dark);
        }

        body {
            display: flex;
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* ─── SIDEBAR ─────────────────────────────────────── */
        .sidebar {
            width: var(--sidebar-w);
            min-height: 100vh;
            height: 100%;
            background: var(--dark);
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
            position: fixed;
            top: 0; left: 0;
            z-index: 200;
            /* Scroll interne si contenu trop long */
            overflow-y: auto;
            overflow-x: hidden;
        }

        /* Scrollbar sidebar */
        .sidebar::-webkit-scrollbar { width: 3px; }
        .sidebar::-webkit-scrollbar-track { background: transparent; }
        .sidebar::-webkit-scrollbar-thumb { background: rgba(201,169,110,0.3); border-radius: 10px; }

        .sidebar::before {
            content: '';
            position: absolute;
            top: -80px; right: -80px;
            width: 220px; height: 220px;
            background: var(--gold);
            opacity: 0.07;
            border-radius: 50%;
            pointer-events: none;
            flex-shrink: 0;
        }

        /* Brand */
        .sidebar-brand {
            padding: 28px 24px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.06);
            flex-shrink: 0;
        }

        .brand-logo {
            display: flex; align-items: center; gap: 10px;
            margin-bottom: 4px;
        }

        .brand-icon {
            width: 36px; height: 36px;
            background: var(--gold); border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            font-size: 18px; flex-shrink: 0;
        }

        .brand-name {
            font-family: 'Playfair Display', serif;
            font-size: 20px; font-weight: 600;
            color: var(--white); letter-spacing: 0.5px;
        }

        .brand-tagline {
            font-size: 10px; font-weight: 300;
            color: var(--text-muted);
            letter-spacing: 2px; text-transform: uppercase;
            padding-left: 46px;
        }

        /* Nav */
        .sidebar-nav {
            padding: 16px 12px;
            flex: 1;
        }

        .nav-section-label {
            font-size: 10px; font-weight: 600;
            letter-spacing: 2.5px; text-transform: uppercase;
            color: var(--text-muted);
            padding: 14px 10px 6px;
        }

        .nav-item {
            display: flex; align-items: center; gap: 11px;
            padding: 9px 10px;
            border-radius: 9px;
            text-decoration: none;
            color: rgba(255,255,255,0.55);
            font-size: 13px; font-weight: 400;
            margin-bottom: 2px;
            transition: all 0.2s;
            position: relative;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .nav-item:hover { background: rgba(255,255,255,0.05); color: var(--white); }

        .nav-item.active {
            background: rgba(201,169,110,0.15);
            color: var(--gold-light);
        }

        .nav-item.active::before {
            content: '';
            position: absolute; left: 0; top: 50%;
            transform: translateY(-50%);
            width: 3px; height: 60%;
            background: var(--gold);
            border-radius: 0 4px 4px 0;
        }

        .nav-icon { width: 18px; height: 18px; opacity: 0.7; flex-shrink: 0; }
        .nav-item.active .nav-icon,
        .nav-item:hover .nav-icon { opacity: 1; }

        .nav-badge {
            margin-left: auto;
            background: var(--gold); color: var(--dark);
            font-size: 10px; font-weight: 600;
            padding: 2px 6px; border-radius: 20px;
            flex-shrink: 0;
        }

        /* Bouton accès rapide */
        .nav-cta {
            display: flex; align-items: center; justify-content: center; gap: 8px;
            margin: 12px 12px 4px;
            background: var(--gold); color: var(--dark);
            padding: 10px 0; border-radius: 8px;
            font-size: 12px; font-weight: 700;
            text-decoration: none;
            transition: opacity 0.2s;
        }
        .nav-cta:hover { opacity: 0.88; }

        /* Technicien card */
        .sidebar-tech {
            margin: 0 12px 12px;
            background: rgba(201,169,110,0.08);
            border: 1px solid rgba(201,169,110,0.2);
            border-radius: 10px;
            padding: 12px 14px;
            flex-shrink: 0;
        }
        .sidebar-tech-label {
            font-size: 10px; font-weight: 700;
            letter-spacing: 1.5px; text-transform: uppercase;
            color: var(--gold); margin-bottom: 8px;
        }
        .sidebar-tech a {
            display: flex; align-items: center; justify-content: center; gap: 7px;
            width: 100%; padding: 8px 0;
            background: var(--gold); color: var(--dark);
            border-radius: 7px; text-decoration: none;
            font-size: 12px; font-weight: 700;
            transition: opacity 0.2s;
        }
        .sidebar-tech a:hover { opacity: 0.88; }

        /* User section */
        .sidebar-user {
            padding: 12px;
            border-top: 1px solid rgba(255,255,255,0.06);
            flex-shrink: 0;
        }

        .user-card {
            display: flex; align-items: center; gap: 10px;
            padding: 8px 10px; border-radius: 9px;
            cursor: pointer; transition: background 0.2s;
        }
        .user-card:hover { background: rgba(255,255,255,0.05); }

        .user-avatar {
            width: 34px; height: 34px;
            background: linear-gradient(135deg, var(--gold), #E8A455);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 13px; font-weight: 600; color: var(--dark);
            flex-shrink: 0;
        }

        .user-info { flex: 1; min-width: 0; }
        .user-name {
            font-size: 12px; font-weight: 500; color: var(--white);
            white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        }
        .user-role { font-size: 10px; color: var(--text-muted); }

        /* ─── MAIN WRAPPER ────────────────────────────────── */
        .main-wrapper {
            margin-left: var(--sidebar-w);
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            /* Permet le scroll vertical du contenu principal */
            min-width: 0;
        }

        /* Top bar */
        .topbar {
            background: var(--white);
            border-bottom: 1px solid #EEECEA;
            padding: 0 28px;
            height: 60px;
            display: flex; align-items: center; justify-content: space-between;
            position: sticky; top: 0; z-index: 100;
            flex-shrink: 0;
        }

        .topbar-left { display: flex; align-items: center; gap: 14px; min-width: 0; }

        .page-title-bar {
            font-family: 'Playfair Display', serif;
            font-size: 18px; font-weight: 600; color: var(--dark);
            white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        }

        .breadcrumb {
            display: flex; align-items: center; gap: 5px;
            font-size: 12px; color: var(--text-muted);
            white-space: nowrap;
        }
        .breadcrumb span { color: var(--dark); }

        .topbar-right { display: flex; align-items: center; gap: 6px; flex-shrink: 0; }

        .topbar-btn {
            width: 36px; height: 36px; border-radius: 9px;
            border: 1px solid #EEECEA; background: transparent;
            cursor: pointer; display: flex; align-items: center; justify-content: center;
            color: var(--text-muted); transition: all 0.2s; position: relative;
        }
        .topbar-btn:hover { background: var(--surface); color: var(--dark); }

        .notif-dot {
            position: absolute; top: 8px; right: 8px;
            width: 6px; height: 6px;
            background: var(--gold); border-radius: 50%;
            border: 2px solid var(--white);
        }

        /* ─── PAGE CONTENT ────────────────────────────────── */
        .page-content {
            padding: 28px 32px;
            flex: 1;
            /* Scroll vertical si le contenu dépasse */
            overflow-y: auto;
            overflow-x: hidden;
        }

        /* Flash messages */
        .flash-success {
            background: #F0FDF4; border: 1px solid #BBF7D0;
            color: #15803D; padding: 11px 16px;
            border-radius: 10px; margin-bottom: 20px;
            font-size: 13px; display: flex; align-items: center; gap: 8px;
        }
        .flash-error {
            background: #FEF2F2; border: 1px solid #FECACA;
            color: #DC2626; padding: 11px 16px;
            border-radius: 10px; margin-bottom: 20px;
            font-size: 13px; display: flex; align-items: center; gap: 8px;
        }

        /* ─── OVERLAY MOBILE ──────────────────────────────── */
        .sidebar-overlay {
            display: none;
            position: fixed; inset: 0;
            background: rgba(0,0,0,0.5);
            z-index: 150;
        }
        .sidebar-overlay.show { display: block; }
        .page-content > * { max-width: 100%; }

        /* ─── RESPONSIVE ──────────────────────────────────── */
        @media (max-width: 1200px) {
            .page-content { padding: 24px 20px; }
            .topbar { padding: 0 20px; }
        }
        @media (max-width: 900px) {
            .sidebar {
                width: min(86vw, 320px);
                transform: translateX(-100%);
                transition: transform 0.28s cubic-bezier(.4,0,.2,1);
                box-shadow: 0 18px 40px rgba(0,0,0,0.25);
            }
            .sidebar.open { transform: translateX(0); }
            .main-wrapper { margin-left: 0; }
            .topbar {
                height: auto;
                min-height: 60px;
                padding: 12px 16px;
                gap: 12px;
                align-items: flex-start;
                flex-wrap: wrap;
            }
            .topbar-left { width: 100%; align-items: flex-start; }
            .topbar-right { margin-left: auto; }
            .page-content { padding: 18px 14px 22px; }
            .mobile-menu-btn { display: flex !important; }
            .nav-item { font-size: 14px; padding: 11px 12px; }
            .nav-cta { margin: 12px 8px 4px; }
            .sidebar-tech { margin: 0 8px 12px; }
        }
        @media (max-width: 640px) {
            .brand-name { font-size: 18px; }
            .brand-tagline { padding-left: 46px; letter-spacing: 1.5px; }
            .topbar-right { width: 100%; justify-content: flex-end; }
            .page-content { padding: 16px 12px 20px; }
        }

        .mobile-menu-btn { display: none; }

        /* ─── SCROLLBAR GLOBAL ────────────────────────────── */
        ::-webkit-scrollbar { width: 5px; height: 5px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #D4CDC6; border-radius: 10px; }
    </style>
</head>
<body>

    <!-- Overlay mobile -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

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
            <a href="{{ route('code.form') }}" class="nav-cta">
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M12 4v16m8-8H4"/>
                </svg>
                Accès locataire / maintenancier
            </a>
            @endif

            <div class="nav-section-label">Principal</div>

            <a href="{{ route('manager.dashboard') }}"
               class="nav-item {{ request()->routeIs('manager.dashboard') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Tableau de bord
            </a>

            <div class="nav-section-label">Portefeuille</div>

            <a href="{{ Route::has('manager.buildings.index') ? route('manager.buildings.index') : '#' }}"
               class="nav-item {{ request()->routeIs('manager.buildings.*') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0H5m14 0h2M5 21H3M9 7h1m-1 4h1m4-4h1m-1 4h1"/>
                </svg>
                Immeubles
            </a>

            <a href="{{ Route::has('manager.apartments.index') ? route('manager.apartments.index') : '#' }}"
               class="nav-item {{ request()->routeIs('manager.apartments.*') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                        d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 22V12h6v10"/>
                </svg>
                Appartements
            </a>

            <a href="{{ Route::has('manager.tenants.index') ? route('manager.tenants.index') : '#' }}"
               class="nav-item {{ request()->routeIs('manager.tenants.*') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                Locataires
            </a>

            <a href="{{ Route::has('leases.index') ? route('leases.index') : '#' }}"
               class="nav-item {{ request()->routeIs('leases.*') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Baux
            </a>

            <div class="nav-section-label">Finance</div>

            <a href="{{ Route::has('payments.index') ? route('payments.index') : '#' }}"
               class="nav-item {{ request()->routeIs('payments.*') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                        d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                </svg>
                Paiements
            </a>

            <a href="{{ Route::has('reports.index') ? route('reports.index') : '#' }}"
               class="nav-item {{ request()->routeIs('reports.*') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                Rapports
            </a>

            <div class="nav-section-label">Système</div>

            <a href="{{ Route::has('settings.index') ? route('settings.index') : '#' }}"
               class="nav-item {{ request()->routeIs('settings.*') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                Paramètres
            </a>

            <a href="{{ Route::has('messages.index') ? route('messages.index') : '#' }}"
               class="nav-item {{ request()->routeIs('messages.*') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                        d="M7 8h10M7 12h6m-9 8l3-3h10a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                Messagerie
            </a>

        </nav>

        {{-- Ajouter un technicien --}}
        <div class="sidebar-tech">
            <div class="sidebar-tech-label">👷 Technicien</div>
            <a href="{{ route('manager.maintenance_workers.index') }}">
                <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M12 4v16m8-8H4"/>
                </svg>
                Voir les techniciens
            </a>
        </div>

        <div class="sidebar-user">
            <div class="user-card">
                <div class="user-avatar">
                    {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                </div>
                <div class="user-info">
                    <div class="user-name">{{ auth()->user()->name ?? 'Utilisateur' }}</div>
                    <div class="user-role">Administrateur</div>
                </div>
                <svg width="14" height="14" fill="none" stroke="#8B8FA8" viewBox="0 0 24 24">
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
                <button class="topbar-btn mobile-menu-btn" id="menuToggle" aria-label="Menu">
                    <svg width="17" height="17" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                <button class="topbar-btn" title="Rechercher">
                    <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </button>

                <button class="topbar-btn" title="Notifications">
                    <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                    <div class="notif-dot"></div>
                </button>

                <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                    @csrf
                    <button type="submit" class="topbar-btn" title="Se déconnecter">
                        <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                <div class="flash-success">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="flash-error">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')

        </main>
    </div>

    <script>
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const menuToggle = document.getElementById('menuToggle');

        function openSidebar() {
            sidebar.classList.add('open');
            overlay.classList.add('show');
            document.body.style.overflow = 'hidden';
        }

        function closeSidebar() {
            sidebar.classList.remove('open');
            overlay.classList.remove('show');
            document.body.style.overflow = '';
        }

        if (menuToggle) {
            menuToggle.addEventListener('click', () => {
                sidebar.classList.contains('open') ? closeSidebar() : openSidebar();
            });
        }

        overlay.addEventListener('click', closeSidebar);

        // Ferme sidebar si on clique un lien (mobile)
        sidebar.querySelectorAll('.nav-item').forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth <= 900) closeSidebar();
            });
        });
    </script>

</body>
</html>
