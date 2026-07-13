<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('page-title', 'Espace Locataire') — ImmoApp</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --sidebar-w: 240px;
            --teal: #0D9488;
            --teal-light: #CCFBF1;
            --dark: #1A1A2E;
            --text-muted: #8B8FA8;
            --surface: #F8F7F5;
            --white: #FFFFFF;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        html, body { height: 100%; font-family: 'DM Sans', sans-serif; background: var(--surface); color: var(--dark); }
        body { display: flex; min-height: 100vh; overflow-x: hidden; }

        .sidebar {
            width: var(--sidebar-w); min-height: 100vh; background: var(--dark);
            display: flex; flex-direction: column; flex-shrink: 0;
            position: fixed; top: 0; left: 0; z-index: 200;
            overflow-y: auto; overflow-x: hidden;
        }
        .sidebar::-webkit-scrollbar { width: 3px; }
        .sidebar::-webkit-scrollbar-thumb { background: rgba(13,148,136,0.3); border-radius: 10px; }

        .sidebar-brand { padding: 28px 24px 20px; border-bottom: 1px solid rgba(255,255,255,0.06); }
        .brand-logo { display: flex; align-items: center; gap: 10px; margin-bottom: 4px; }
        .brand-icon { width: 36px; height: 36px; background: var(--teal); border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 18px; }
        .brand-name { font-family: 'Playfair Display', serif; font-size: 20px; font-weight: 600; color: #fff; }
        .brand-tagline { font-size: 10px; font-weight: 300; color: var(--text-muted); letter-spacing: 2px; text-transform: uppercase; padding-left: 46px; }

        .sidebar-nav { padding: 16px 12px; flex: 1; }
        .nav-section-label { font-size: 10px; font-weight: 600; letter-spacing: 2.5px; text-transform: uppercase; color: var(--text-muted); padding: 14px 10px 6px; }
        .nav-item {
            display: flex; align-items: center; gap: 11px; padding: 9px 10px;
            border-radius: 9px; text-decoration: none; color: rgba(255,255,255,0.55);
            font-size: 13px; font-weight: 400; margin-bottom: 2px; transition: all 0.2s;
            position: relative; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        }
        .nav-item:hover { background: rgba(255,255,255,0.05); color: #fff; }
        .nav-item.active { background: rgba(13,148,136,0.15); color: var(--teal-light); }
        .nav-item.active::before {
            content: ''; position: absolute; left: 0; top: 50%; transform: translateY(-50%);
            width: 3px; height: 60%; background: var(--teal); border-radius: 0 4px 4px 0;
        }
        .nav-icon { width: 18px; height: 18px; opacity: 0.7; flex-shrink: 0; }
        .nav-item.active .nav-icon, .nav-item:hover .nav-icon { opacity: 1; }

        .sidebar-user { padding: 12px; border-top: 1px solid rgba(255,255,255,0.06); }
        .user-card { display: flex; align-items: center; gap: 10px; padding: 8px 10px; border-radius: 9px; }
        .user-avatar { width: 34px; height: 34px; background: linear-gradient(135deg, var(--teal), #0891B2); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 13px; font-weight: 600; color: #fff; flex-shrink: 0; }
        .user-info { flex: 1; min-width: 0; }
        .user-name { font-size: 12px; font-weight: 500; color: #fff; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .user-role { font-size: 10px; color: var(--text-muted); }

        .main-wrapper { margin-left: var(--sidebar-w); flex: 1; display: flex; flex-direction: column; min-height: 100vh; min-width: 0; }

        .topbar { background: #fff; border-bottom: 1px solid #EEECEA; padding: 0 28px; height: 60px; display: flex; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 100; }
        .topbar-left { display: flex; align-items: center; gap: 14px; }
        .page-title-bar { font-family: 'Playfair Display', serif; font-size: 18px; font-weight: 600; color: var(--dark); }
        .breadcrumb { font-size: 12px; color: var(--text-muted); }
        .topbar-right { display: flex; align-items: center; gap: 6px; }
        .topbar-btn { width: 36px; height: 36px; border-radius: 9px; border: 1px solid #EEECEA; background: transparent; cursor: pointer; display: flex; align-items: center; justify-content: center; color: var(--text-muted); transition: all 0.2s; }
        .topbar-btn:hover { background: var(--surface); color: var(--dark); }

        .page-content { padding: 28px 32px; flex: 1; overflow-y: auto; }

        .flash-success { background: #F0FDF4; border: 1px solid #BBF7D0; color: #15803D; padding: 11px 16px; border-radius: 10px; margin-bottom: 20px; font-size: 13px; display: flex; align-items: center; gap: 8px; }
        .flash-error { background: #FEF2F2; border: 1px solid #FECACA; color: #DC2626; padding: 11px 16px; border-radius: 10px; margin-bottom: 20px; font-size: 13px; display: flex; align-items: center; gap: 8px; }

        .sidebar-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 150; }
        .sidebar-overlay.show { display: block; }
        .page-content > * { max-width: 100%; }

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
        }
        @media (max-width: 640px) {
            .brand-name { font-size: 18px; }
            .brand-tagline { padding-left: 46px; letter-spacing: 1.5px; }
            .topbar-right { width: 100%; justify-content: flex-end; }
            .page-content { padding: 16px 12px 20px; }
        }
        .mobile-menu-btn { display: none; }
        ::-webkit-scrollbar { width: 5px; height: 5px; }
        ::-webkit-scrollbar-thumb { background: #D4CDC6; border-radius: 10px; }
    </style>
</head>
<body>
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <aside class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <div class="brand-logo">
                <div class="brand-icon">🏠</div>
                <span class="brand-name">ImmoApp</span>
            </div>
            <div class="brand-tagline">Espace locataire</div>
        </div>

        <nav class="sidebar-nav">
            <div class="nav-section-label">Menu</div>

            <a href="{{ route('tenant.dashboard') }}"
               class="nav-item {{ request()->routeIs('tenant.dashboard') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Tableau de bord
            </a>

            <a href="{{ route('tenant.tickets.index') }}"
               class="nav-item {{ request()->routeIs('tenant.tickets.*') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                Mes tickets
            </a>

            <a href="{{ route('tenant.payments.index') }}"
               class="nav-item {{ request()->routeIs('tenant.payments.*') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                        d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                </svg>
                Mes paiements
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

        <div class="sidebar-user">
            <div class="user-card">
                <div class="user-avatar">
                    {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                </div>
                <div class="user-info">
                    <div class="user-name">{{ auth()->user()->name ?? 'Locataire' }}</div>
                    <div class="user-role">Locataire</div>
                </div>
                <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                    @csrf
                    <button type="submit" style="background:none;border:none;cursor:pointer;color:#8B8FA8;display:flex;align-items:center;" title="Déconnexion">
                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <div class="main-wrapper">
        <header class="topbar">
            <div class="topbar-left">
                <button class="topbar-btn mobile-menu-btn" id="menuToggle">
                    <svg width="17" height="17" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
                <div>
                    <div class="page-title-bar">@yield('page-title', 'Tableau de bord')</div>
                    <div class="breadcrumb">@yield('breadcrumb', 'Espace locataire')</div>
                </div>
            </div>
            <div class="topbar-right">
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
        if (menuToggle) {
            menuToggle.addEventListener('click', () => {
                sidebar.classList.toggle('open');
                overlay.classList.toggle('show');
            });
        }
        overlay.addEventListener('click', () => {
            sidebar.classList.remove('open');
            overlay.classList.remove('show');
        });
    </script>
</body>
</html>
