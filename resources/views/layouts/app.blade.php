<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#f5f7f1">

    <title>@yield('title', 'Milnkys') · Milnkys</title>

    <style>
        :root {
            --primary: #718765;
            --primary-dark: #465b3d;
            --primary-soft: #e8eee2;
            --bg: #f5f7f1;
            --surface: #ffffff;
            --text: #263326;
            --muted: #899184;
            --border: #edf0e8;
            --radius: 22px;
            --danger: #b54747;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: Inter, "Segoe UI", Arial, sans-serif;
            color: var(--text);
            background: var(--bg);
            -webkit-font-smoothing: antialiased;
        }

        a { color: inherit; text-decoration: none; }
        button, input, select, textarea { font: inherit; }

        .app {
            min-height: 100vh;
            max-width: 1600px;
            margin: 0 auto;
            display: flex;
        }

        .sidebar {
            width: 250px;
            flex-shrink: 0;
            padding: 28px 18px;
            background: var(--surface);
            border-right: 1px solid var(--border);
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0 10px;
            margin-bottom: 38px;
        }

        .brand-logo {
            width: 46px;
            height: 46px;
            display: grid;
            place-items: center;
            border-radius: 16px;
            color: white;
            background: var(--primary);
            font-size: 24px;
            box-shadow: 0 6px 14px #71876530;
        }

        .brand-name {
            font-size: 20px;
            font-weight: 800;
            letter-spacing: -.7px;
        }

        .brand-sub {
            margin-top: 4px;
            color: var(--muted);
            font-size: 11px;
        }

        .menu-label {
            margin: 24px 12px 10px;
            color: #a0a79a;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 1.4px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 13px;
            padding: 14px;
            margin: 4px 0;
            border-radius: 14px;
            color: #747e6d;
            font-size: 13px;
            font-weight: 600;
            transition: .2s;
        }

        .nav-link:hover { background: var(--bg); }

        .nav-link.active {
            color: var(--primary-dark);
            background: var(--primary-soft);
        }

        .nav-icon {
            width: 23px;
            text-align: center;
            font-size: 18px;
        }

        .sidebar-note {
            margin-top: 38px;
            padding: 18px;
            background: var(--bg);
            border-radius: 18px;
        }

        .sidebar-note strong {
            display: block;
            margin-bottom: 7px;
            font-size: 13px;
        }

        .sidebar-note p {
            margin: 0;
            color: var(--muted);
            font-size: 11px;
            line-height: 1.7;
        }

        .main {
            flex: 1;
            min-width: 0;
            padding: 30px clamp(18px, 4vw, 48px);
        }

        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
            margin-bottom: 30px;
        }

        .eyebrow {
            color: var(--primary);
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 1.5px;
            text-transform: uppercase;
        }

        .page-title {
            margin: 7px 0 0;
            font-size: clamp(23px, 3vw, 30px);
            letter-spacing: -1px;
        }

        .page-subtitle {
            margin: 8px 0 0;
            color: var(--muted);
            font-size: 13px;
            line-height: 1.6;
        }

        .profile-menu { position: relative; flex-shrink: 0; }

        .profile-toggle {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 0;
            border: 0;
            background: transparent;
            cursor: pointer;
            color: inherit;
        }

        .profile {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 13px 9px 9px;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 17px;
        }

        .avatar {
            width: 38px;
            height: 38px;
            display: grid;
            place-items: center;
            border-radius: 13px;
            background: var(--primary-soft);
            color: var(--primary-dark);
            font-weight: 800;
        }

        .profile-name { font-size: 12px; font-weight: 800; }
        .profile-role { margin-top: 4px; color: var(--muted); font-size: 10px; }
        .profile-chevron { color: var(--muted); font-size: 12px; }

        .profile-dropdown {
            display: none;
            position: absolute;
            z-index: 30;
            top: calc(100% + 10px);
            right: 0;
            width: 220px;
            padding: 7px;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 15px;
            box-shadow: 0 12px 30px #26332618;
        }

        .profile-menu.open .profile-dropdown { display: block; }

        .profile-dropdown a,
        .profile-dropdown button {
            display: flex;
            width: 100%;
            align-items: center;
            gap: 10px;
            padding: 12px;
            border: 0;
            border-radius: 10px;
            background: transparent;
            color: var(--text);
            text-align: left;
            font-size: 12px;
            cursor: pointer;
        }

        .profile-dropdown a:hover,
        .profile-dropdown button:hover { background: var(--bg); }

        .profile-dropdown form { margin: 0; }
        .profile-dropdown .logout-button { color: var(--danger); }

        .settings-toggle {
            display: flex;
            justify-content: space-between;
            width: 100%;
        }

        .settings-submenu {
            display: none;
            margin: 2px 0 7px 12px;
            padding-left: 8px;
            border-left: 1px solid var(--border);
        }

        .settings-submenu.open { display: block; }
        .settings-submenu a { padding: 10px !important; font-size: 11px !important; }

        .page-content { min-width: 0; }

        .section-heading {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            margin: 10px 0 18px;
        }

        .section-heading h2,
        .section-heading h3 {
            margin: 0;
            font-size: 17px;
            letter-spacing: -.3px;
        }

        .section-caption { color: var(--muted); font-size: 11px; }

        .panel {
            padding: 25px;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: 0 5px 20px #26332605;
        }

        .panel-header { margin-bottom: 22px; }
        .panel-header h2 { margin: 0; font-size: 17px; }
        .panel-header p {
            margin: 7px 0 0;
            color: var(--muted);
            font-size: 12px;
            line-height: 1.7;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 20px;
        }

        .form-group { min-width: 0; }
        .form-group.full { grid-column: 1 / -1; }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-size: 12px;
            font-weight: 700;
        }

        .required { color: #b54747; }

        .form-control {
            width: 100%;
            min-height: 45px;
            padding: 11px 13px;
            color: var(--text);
            background: #fff;
            border: 1px solid #e3e8dd;
            border-radius: 12px;
            outline: none;
            transition: border-color .2s, box-shadow .2s;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px #71876520;
        }

        textarea.form-control { min-height: 100px; resize: vertical; }

        .form-help {
            margin-top: 7px;
            color: var(--muted);
            font-size: 11px;
            line-height: 1.6;
        }

        .form-error { margin-top: 7px; color: var(--danger); font-size: 11px; }

        .alert {
            padding: 14px 16px;
            margin-bottom: 20px;
            border-radius: 13px;
            font-size: 12px;
            line-height: 1.7;
        }

        .alert-success { color: #365b32; background: #e8eee2; }
        .alert-error { color: #9f3030; background: #fff0f0; }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            min-height: 43px;
            padding: 11px 17px;
            border: 1px solid transparent;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
            transition: .2s;
        }

        .btn-primary { color: white; background: var(--primary); }
        .btn-primary:hover { background: var(--primary-dark); }
        .btn-secondary { color: var(--text); background: white; border-color: var(--border); }
        .btn-secondary:hover { background: var(--bg); }

        .form-actions {
            display: flex;
            justify-content: flex-end;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 25px;
            padding-top: 20px;
            border-top: 1px solid var(--border);
        }

        .table-wrap { overflow-x: auto; }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            white-space: nowrap;
        }

        .data-table th {
            padding: 14px 13px;
            color: #788270;
            background: #f8f9f5;
            text-align: left;
            font-size: 10px;
            letter-spacing: .6px;
            text-transform: uppercase;
        }

        .data-table td {
            padding: 15px 13px;
            border-bottom: 1px solid var(--border);
            font-size: 12px;
        }

        .data-table tbody tr:hover { background: #fafbf8; }

        .order-number { color: var(--primary-dark); font-weight: 800; }

        .badge {
            display: inline-flex;
            align-items: center;
            padding: 6px 9px;
            border-radius: 30px;
            background: var(--primary-soft);
            color: var(--primary-dark);
            font-size: 10px;
            font-weight: 700;
        }

        .empty-state { padding: 35px 15px; text-align: center; }
        .empty-icon {
            width: 58px;
            height: 58px;
            display: grid;
            place-items: center;
            margin: 0 auto 14px;
            border-radius: 20px;
            background: var(--bg);
            font-size: 25px;
        }
        .empty-state strong { font-size: 13px; }
        .empty-state p {
            margin: 8px auto 0;
            max-width: 330px;
            color: var(--muted);
            font-size: 11px;
            line-height: 1.8;
        }

        .pagination-wrap { margin-top: 20px; }

        .footer {
            padding: 27px 0 8px;
            color: var(--muted);
            text-align: center;
            font-size: 10px;
        }

        .bottom-nav { display: none; }

        @media (max-width: 900px) {
            .sidebar { width: 215px; }
        }

        @media (max-width: 640px) {
            body { padding-bottom: calc(78px + env(safe-area-inset-bottom)); }
            .sidebar { display: none; }
            .main { padding: 23px 16px 20px; }
            .topbar { margin-bottom: 24px; }
            .page-title { font-size: 24px; }
            .page-subtitle { max-width: 230px; font-size: 11px; }
            .profile { padding: 6px; border-radius: 15px; }
            .avatar { width: 37px; height: 37px; }
            .profile-info { display: none; }
            .form-grid { grid-template-columns: 1fr; gap: 17px; }
            .form-group.full { grid-column: auto; }
            .panel { padding: 19px 15px; border-radius: 20px; }
            .section-heading { align-items: flex-start; }
            .form-actions .btn { flex: 1; }
            .bottom-nav {
                position: fixed;
                z-index: 20;
                right: 0;
                bottom: 0;
                left: 0;
                display: grid;
                grid-template-columns: repeat(4, minmax(0, 1fr));
                padding: 9px 7px calc(9px + env(safe-area-inset-bottom));
                background: #ffffffed;
                border-top: 1px solid var(--border);
                backdrop-filter: blur(18px);
            }
            .bottom-link {
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                gap: 5px;
                padding: 5px 2px;
                color: #8a9383;
                font-size: 9px;
                font-weight: 600;
            }
            .bottom-link .nav-icon { width: auto; font-size: 21px; }
            .bottom-link.active { color: var(--primary-dark); }
            .bottom-link.active .nav-icon {
                padding: 4px 15px;
                border-radius: 20px;
                background: var(--primary-soft);
            }
        }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after { transition: none !important; }
        }

        
.purchase-actions {
    display: flex;
    justify-content: flex-end;
    align-items: center;
    gap: 5px;
    white-space: nowrap;
}

.purchase-actions form {
    margin: 0;
    padding: 0;
}

.btn-action {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 5px 9px;
    border: 1px solid transparent;
    border-radius: 5px;
    font-size: 11px;
    line-height: 1.3;
    font-weight: 600;
    text-decoration: none;
    cursor: pointer;
}

.btn-view {
    color: #475569;
    background: #f1f5f9;
    border-color: #e2e8f0;
}

.btn-edit {
    color: #526b3d;
    background: #edf3e7;
    border-color: #d6e3c9;
}

.btn-delete {
    color: #b42318;
    background: #fef0ef;
    border-color: #f5d0cc;
}

.btn-action:hover {
    filter: brightness(0.96);
}

    </style>

    @stack('styles')
</head>
<body>
<div class="app">
    <aside class="sidebar">
        <a href="{{ route('dashboard') }}" class="brand">
            <div class="brand-logo">📦</div>
            <div>
                <div class="brand-name">Milnkys</div>
                <div class="brand-sub">Japan Warehouse Manager</div>
            </div>
        </a>

        <div class="menu-label">WORKSPACE</div>

        <a href="{{ route('dashboard') }}"
           class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <span class="nav-icon">⌂</span> Dashboard
        </a>

        <a href="{{ route('purchase-orders.index') }}"
           class="nav-link {{ request()->routeIs('purchase-orders.*') ? 'active' : '' }}">
            <span class="nav-icon">🛍</span> Input Purchase
        </a>

        <a href="{{ route('arrived-items.index') }}" class="nav-link">
    <span class="nav-icon">📦</span> Input Arrived
</a>

        <a href="{{ route('shipment-batches.recap') }}" class="nav-link">
            <span class="nav-icon">🚚</span> Rekap Pengiriman
        </a>

        <div class="menu-label">MANAJEMEN</div>
        <a href="{{ route('laporan.index') }}" class="nav-link">
            <span class="nav-icon">▤</span> Laporan
        </a>

        <div class="sidebar-note">
            <strong>✦ Milnkys Workspace</strong>
            <p>Kelola pesanan Jepang, biaya gudang, dan pengiriman ke Indonesia dengan lebih teratur.</p>
        </div>
    </aside>

    <main class="main">
        <header class="topbar">
            <div>
                <div class="eyebrow">Milnkys WORKSPACE</div>
                <h1 class="page-title">@yield('page-title', 'Dashboard')</h1>
                <p class="page-subtitle">@yield('page-subtitle', 'Semua aktivitas gudang dalam satu tempat.')</p>
            </div>

            <div class="profile-menu" id="profileMenu">
                <button type="button" class="profile-toggle" id="profileToggle"
                        aria-expanded="false" aria-controls="profileDropdown">
                    <span class="profile">
                        <span class="avatar">
                            {{ strtoupper(substr(auth()->user()->name ?? 'M', 0, 1)) }}
                        </span>
                        <span class="profile-info">
                            <span class="profile-name">{{ auth()->user()->name ?? 'Pengguna' }}</span>
                            <span class="profile-role">{{ ucfirst(auth()->user()->role ?? 'user') }}</span>
                        </span>
                    </span>
                    <span class="profile-chevron">⌄</span>
                </button>

                <div class="profile-dropdown" id="profileDropdown">
                    <a href="{{ route('profile.edit') }}">👤 &nbsp; Profil Pengguna</a>

                    @if (auth()->user()->role === 'admin')
                        <div>
                            <button type="button" class="settings-toggle" id="settingsToggle">
                                <span>⚙ &nbsp; Pengaturan</span>
                                <span>⌄</span>
                            </button>
                            <div class="settings-submenu" id="settingsSubmenu">
                                <a href="{{ route('purchase-types.index') }}">Jenis Purchase</a>
                                <a href="{{ route('payment-types.index') }}">Jenis Payment</a>
                                <a href="{{ route('exchange-rates.index') }}">Kurs Mata Uang</a>
                                <a href="{{ route('shipment-batches.index') }}">Atur Batch Box</a>
                                <a href="{{ route('employees.index') }}">Akun Karyawan</a>
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="logout-button">↪ &nbsp; Logout</button>
                    </form>
                </div>
            </div>
        </header>

        <div class="page-content">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @yield('content')
        </div>

        <footer class="footer">Milnkys · Japan Warehouse Manager</footer>
    </main>
</div>

<nav class="bottom-nav">
    <a href="{{ route('dashboard') }}"
       class="bottom-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <span class="nav-icon">⌂</span><span>Beranda</span>
    </a>
    <a href="{{ route('purchase-orders.index') }}"
       class="bottom-link {{ request()->routeIs('purchase-orders.*') ? 'active' : '' }}">
        <span class="nav-icon">🛍</span><span>Input Purchase</span>
    </a>
    <a href="{{ route('arrived-items.index') }}" class="bottom-link">
        <span class="nav-icon">📦</span><span>Input Arrived</span>
    </a>
    <a href="{{ route('shipment-batches.recap') }}" class="bottom-link">
        <span class="nav-icon">🚚</span><span>Rekap Pengiriman</span>
    </a>
</nav>

<script>
    const profileMenu = document.getElementById('profileMenu');
    const profileToggle = document.getElementById('profileToggle');
    const settingsToggle = document.getElementById('settingsToggle');
    const settingsSubmenu = document.getElementById('settingsSubmenu');

    profileToggle?.addEventListener('click', function () {
        const opened = profileMenu.classList.toggle('open');
        profileToggle.setAttribute('aria-expanded', String(opened));
    });

    settingsToggle?.addEventListener('click', function (event) {
        event.stopPropagation();
        const opened = settingsSubmenu.classList.toggle('open');
        settingsToggle.setAttribute('aria-expanded', String(opened));
    });

    document.addEventListener('click', function (event) {
        if (profileMenu && !profileMenu.contains(event.target)) {
            profileMenu.classList.remove('open');
            profileToggle?.setAttribute('aria-expanded', 'false');
        }
    });
</script>

@stack('scripts')
</body>
</html>
