<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="{{ $themeColors['background'] ?? '#F5F8FF' }}">
    <title>Milnkys</title>

    <style>
        :root {
            --primary: {{ $themeColors['primary'] ?? '#2563EB' }};
            --primary-dark: {{ $themeColors['primary_dark'] ?? '#1D4ED8' }};
            --primary-soft: {{ $themeColors['primary_soft'] ?? '#DBEAFE' }};
            --bg: {{ $themeColors['background'] ?? '#F5F8FF' }};
            --surface: {{ $themeColors['surface'] ?? '#FFFFFF' }};
            --text: {{ $themeColors['text'] ?? '#1E293B' }};
            --muted: {{ $themeColors['muted'] ?? '#64748B' }};
            --border: {{ $themeColors['border'] ?? '#E2E8F0' }};
            --danger: {{ $themeColors['danger'] ?? '#DC2626' }};
            --radius: 22px;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Inter, "Segoe UI", Arial, sans-serif;
            color: var(--text);
            background: var(--bg);
            -webkit-font-smoothing: antialiased;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        button {
            font: inherit;
        }

        .app {
            min-height: 100vh;
            max-width: 1600px;
            margin: 0 auto;
            display: flex;
        }

        /* Navigasi desktop */

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
            box-shadow: 0 6px 14px color-mix(in srgb, var(--primary) 19%, transparent);
        }

        .brand-name {
            font-size: 20px;
            font-weight: 800;
            letter-spacing: -0.7px;
        }

        .brand-sub {
            margin-top: 4px;
            color: var(--muted);
            font-size: 11px;
        }

        .menu-label {
            margin: 24px 12px 10px;
            color: var(--muted);
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
            color: var(--muted);
            font-size: 13px;
            font-weight: 600;
            transition: .2s;
        }

        .nav-link:hover {
            background: var(--bg);
        }

        .nav-link.active {
            color: var(--primary-dark);
            background: var(--primary-soft);
        }

        /* Dropdown menu akun kanan atas */
        .profile-menu {
            position: relative;
            flex-shrink: 0;
        }

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

        .profile-chevron {
            color: var(--muted);
            font-size: 12px;
            transition: transform .2s;
        }

        .profile-menu.open .profile-chevron {
            transform: rotate(180deg);
        }

        .profile-dropdown {
            display: none;
            position: absolute;
            z-index: 30;
            top: calc(100% + 10px);
            right: 0;
            width: 205px;
            padding: 7px;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 15px;
            box-shadow: 0 12px 30px #1E293B18;
        }

        .profile-menu.open .profile-dropdown {
            display: block;
        }

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
        .profile-dropdown button:hover {
            background: var(--bg);
        }

        .profile-dropdown .logout-button {
            color: var(--danger);
        }

        /* Dropdown submenu Pengaturan */
        .profile-settings-toggle {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            padding: 12px;
            border: 0;
            border-radius: 10px;
            background: transparent;
            color: var(--text);
            text-align: left;
            font-size: 12px;
            cursor: pointer;
        }

        .profile-settings-toggle:hover {
            background: var(--bg);
        }

        .profile-settings-toggle .settings-chevron {
            margin-left: auto;
            color: var(--muted);
            transition: transform .2s;
        }

        .profile-settings.open .settings-chevron {
            transform: rotate(180deg);
        }

        .profile-settings-submenu {
            display: none;
            margin: 2px 0 7px 12px;
            padding-left: 8px;
            border-left: 1px solid var(--border);
        }

        .profile-settings.open .profile-settings-submenu {
            display: block;
        }

        .profile-settings-submenu a {
            padding: 10px !important;
            font-size: 11px !important;
        }

        .profile-dropdown form {
            margin: 0;
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

        /* Konten utama */

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

        .profile-name {
            font-size: 12px;
            font-weight: 800;
        }

        .profile-role {
            margin-top: 4px;
            color: var(--muted);
            font-size: 10px;
        }

        /* Banner */

        .hero {
            position: relative;
            overflow: hidden;
            padding: 29px;
            margin-bottom: 27px;
            border-radius: 26px;
            color: white;
            background: linear-gradient(120deg, var(--primary-dark), var(--primary));
        }

        .hero::after {
            content: "箱";
            position: absolute;
            right: 24px;
            bottom: -52px;
            color: #ffffff12;
            font-size: 180px;
            font-weight: 900;
            line-height: 1;
            pointer-events: none;
        }

        .hero-content {
            position: relative;
            z-index: 1;
            max-width: 510px;
        }

        .hero-label {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 7px 11px;
            border: 1px solid #ffffff35;
            background: #ffffff12;
            border-radius: 30px;
            font-size: 10px;
            font-weight: 700;
        }

        .hero h2 {
            margin: 19px 0 10px;
            font-size: clamp(22px, 3vw, 29px);
            line-height: 1.3;
            letter-spacing: -.8px;
        }

        .hero p {
            max-width: 410px;
            margin: 0;
            color: var(--primary-soft);
            font-size: 12px;
            line-height: 1.9;
        }

        /* Statistik */

        .section-heading {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            margin: 29px 0 15px;
        }

        .section-heading h3 {
            margin: 0;
            font-size: 16px;
            letter-spacing: -.3px;
        }

        .section-caption {
            color: var(--muted);
            font-size: 11px;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 17px;
        }

        .stat-card {
            min-width: 0;
            padding: 22px;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: 0 5px 20px #1E293B08;
        }

        .stat-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
        }

        .stat-icon {
            width: 45px;
            height: 45px;
            display: grid;
            place-items: center;
            border-radius: 15px;
            font-size: 21px;
        }

        .stat-icon.green {
            color: var(--primary-dark);
            background: var(--primary-soft);
        }

        .stat-icon.gold {
            color: #a17c35;
            background: #f8f0dd;
        }

        .stat-label {
            margin-top: 19px;
            color: var(--muted);
            font-size: 12px;
        }

        .stat-value {
            overflow-wrap: anywhere;
            margin-top: 9px;
            font-size: clamp(22px, 3vw, 30px);
            font-weight: 800;
            letter-spacing: -1px;
        }

        .stat-description {
            margin-top: 9px;
            color: var(--muted);
            font-size: 10px;
            line-height: 1.6;
        }

        /* Akses cepat */

        .quick-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 14px;
        }

        .quick-card {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            min-width: 0;
            padding: 19px 16px;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 20px;
            transition: transform .2s, box-shadow .2s;
        }

        .quick-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 24px #1E293B12;
        }

        .quick-icon {
            width: 44px;
            height: 44px;
            display: grid;
            place-items: center;
            margin-bottom: 17px;
            border-radius: 15px;
            background: var(--primary-soft);
            font-size: 21px;
        }

        .quick-card strong {
            font-size: 12px;
            line-height: 1.5;
        }

        .quick-card span {
            margin-top: 6px;
            color: var(--muted);
            font-size: 10px;
            line-height: 1.5;
        }

        /* Aktivitas */

        .activity-card {
            padding: 22px;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
        }

        .empty-state {
            padding: 26px 10px;
            text-align: center;
        }

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

        .empty-state strong {
            font-size: 13px;
        }

        .empty-state p {
            margin: 8px auto 0;
            max-width: 300px;
            color: var(--muted);
            font-size: 11px;
            line-height: 1.8;
        }

        .footer {
            padding: 27px 0 8px;
            color: var(--muted);
            text-align: center;
            font-size: 10px;
        }

        /* Navigasi bawah Android */

        .bottom-nav {
            display: none;
        }

        @media (max-width: 900px) {
            .sidebar {
                width: 215px;
            }

            .quick-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 640px) {
            body {
                padding-bottom: calc(78px + env(safe-area-inset-bottom));
            }

            .sidebar {
                display: none;
            }

            .main {
                padding: 23px 16px 20px;
            }

            .topbar {
                margin-bottom: 24px;
            }

            .page-title {
                font-size: 24px;
            }

            .page-subtitle {
                max-width: 230px;
                font-size: 11px;
            }

            .profile {
                padding: 6px;
                border-radius: 15px;
            }

            .avatar {
                width: 37px;
                height: 37px;
            }

            .profile-info {
                display: none;
            }

            .hero {
                padding: 24px 21px;
                margin-bottom: 26px;
                border-radius: 23px;
            }

            .hero h2 {
                max-width: 280px;
                font-size: 24px;
            }

            .hero p {
                max-width: 270px;
                font-size: 11px;
            }

            .hero::after {
                right: -10px;
                bottom: -26px;
                font-size: 120px;
            }

            .section-heading {
                margin-top: 26px;
            }

            .stats {
                gap: 11px;
            }

            .stat-card {
                padding: 16px 13px;
                border-radius: 19px;
            }

            .stat-icon {
                width: 38px;
                height: 38px;
                border-radius: 13px;
                font-size: 18px;
            }

            .stat-label {
                margin-top: 16px;
                font-size: 10px;
                line-height: 1.5;
            }

            .stat-value {
                font-size: clamp(19px, 6vw, 25px);
                letter-spacing: -.8px;
            }

            .stat-description {
                font-size: 9px;
            }

            .quick-grid {
                gap: 11px;
            }

            .quick-card {
                padding: 16px 14px;
                border-radius: 19px;
            }

            .quick-icon {
                width: 40px;
                height: 40px;
                margin-bottom: 13px;
                font-size: 19px;
            }

            .quick-card strong {
                font-size: 11px;
            }

            .quick-card span {
                font-size: 9px;
            }

            .activity-card {
                padding: 17px 13px;
                border-radius: 20px;
            }

            .bottom-nav {
                position: fixed;
                z-index: 20;
                right: 0;
                bottom: 0;
                left: 0;
                display: grid;
                grid-template-columns: repeat(4, minmax(0, 1fr));
                padding: 9px 7px calc(9px + env(safe-area-inset-bottom));
                background: color-mix(in srgb, var(--surface) 93%, transparent);
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
                color: var(--muted);
                font-size: 9px;
                font-weight: 600;
            }

            .bottom-link .nav-icon {
                width: auto;
                font-size: 21px;
            }

            .bottom-link.active {
                color: var(--primary-dark);
            }

            .bottom-link.active .nav-icon {
                padding: 4px 15px;
                border-radius: 20px;
                background: var(--primary-soft);
            }
        }

        @media (prefers-reduced-motion: reduce) {
            *,
            *::before,
            *::after {
                transition: none !important;
            }
        }
    </style>
</head>
<body>
<div class="app">

    <aside class="sidebar">
        <a href="/" class="brand">
            <div class="brand-logo">📦</div>
            <div>
                <div class="brand-name">Milnkys</div>
                <div class="brand-sub">Japan Warehouse Manager</div>
            </div>
        </a>

        <div class="menu-label">WORKSPACE</div>

        <a href="/" class="nav-link active">
            <span class="nav-icon">⌂</span> Dashboard
        </a>
        <a href="{{ route('purchase-orders.index') }}" class="nav-link">
    <span class="nav-icon">🛍</span> Input Purchase
</a>
        <a href="{{ route('arrived-items.index') }}" class="nav-link">
            <span class="nav-icon">📦</span> Input Arrived
        </a>
        <a href="{{ route('shipment-batches.recap') }}" class="nav-link">
            <span class="nav-icon">🚚</span> Rekap Pengiriman
        </a>

        <div class="menu-label">MANAJEMEN</div>

        <a href="/laporan" class="nav-link">
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
                <h1 class="page-title">Dashboard</h1>
                <p class="page-subtitle">Semua aktivitas gudang dalam satu tempat.</p>
            </div>

            
<div class="profile-menu" id="profileMenu">
    <button type="button" class="profile-toggle" id="profileToggle"
            aria-expanded="false" aria-controls="profileDropdown">
        <span class="profile">
            <span class="avatar">
                {{ strtoupper(substr(auth()->user()->name ?? 'M', 0, 1)) }}
            </span>

            <span class="profile-info">
                <span class="profile-name">
                    {{ auth()->user()->name ?? 'Pengguna' }}
                </span>
                <span class="profile-role">
                    {{ ucfirst(auth()->user()->role ?? 'user') }}
                </span>
            </span>
        </span>

        <span class="profile-chevron">⌄</span>
    </button>

    <div class="profile-dropdown" id="profileDropdown">

        <a href="{{ route('profile.edit') }}">
            <span>👤</span> Pengguna
        </a>

        <div class="profile-settings" id="profileSettings">
            <button type="button"
                    class="profile-settings-toggle"
                    id="profileSettingsToggle"
                    aria-expanded="false"
                    aria-controls="profileSettingsSubmenu">
                <span>⚙ &nbsp; Pengaturan</span>
                <span class="settings-chevron">⌄</span>
            </button>

            <div class="profile-settings-submenu" id="profileSettingsSubmenu">
                <a href="{{ route('purchase-types.index') }}">Jenis Purchase</a>
                <a href="{{ route('payment-types.index') }}">Jenis Payment</a>
                <a href="{{ route('exchange-rates.index') }}">Kurs Mata Uang</a>
                 <a href="{{ route('shipment-batches.index') }}">Atur Batch Box</a>
                <a href="{{ route('employees.index') }}">Akun Karyawan</a>
                <a href="{{ route('theme-settings.index') }}">🎨 Pengaturan Tema</a>
            </div>
            
        </div>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="logout-button">
                <span>↪</span> Logout
            </button>
        </form>

    </div>
</div>

        </header>

        <section class="hero">
            <div class="hero-content">
                <div class="hero-label">✦ JAPAN TO INDONESIA</div>
                <h2>Halo, Milnkys!</h2>
                    <!-- <br>Semua pesanan lebih teratur.</h2> -->
                <p>
                    Semua pesanan lebih teratur
                </p>
            </div>
        </section>

        <section>
    <div class="section-heading">
        <h3>Ringkasan Gudang</h3>
        <span class="section-caption">Semua periode</span>
    </div>

    @php
        use App\Models\PurchaseOrder;
        use App\Models\ArrivedItem;
        use App\Models\ExchangeRate;

        // Total biaya gudang dalam JPY
        $totalBiayaGudang = PurchaseOrder::sum('warehouse_fee_jpy');

        // Ambil kurs JPY ke IDR yang aktif
        $kurs = ExchangeRate::current();

        // Estimasi biaya dalam Rupiah
        $estimasiRupiah = $kurs
            ? $totalBiayaGudang * (float) $kurs->rate
            : 0;

        // Total seluruh resi yang tercatat
        $totalResi = ArrivedItem::count();
    @endphp

    <div class="stats">
        {{-- Total Biaya Gudang JPY --}}
        <article class="stat-card">
            <div class="stat-top">
                <div class="stat-icon green">¥</div>
                <span class="section-caption">JPY</span>
            </div>

            <div class="stat-label">Total Biaya Gudang</div>

            <div class="stat-value">
                ¥ {{ number_format((float) $totalBiayaGudang, 0, ',', '.') }}
            </div>

            <div class="stat-description">
                Akumulasi biaya gudang tercatat
            </div>
        </article>

        {{-- Estimasi Biaya Rupiah --}}
        <article class="stat-card">
            <div class="stat-top">
                <div class="stat-icon green">⇄</div>
                <span class="section-caption">IDR</span>
            </div>

            <div class="stat-label">Estimasi Biaya dalam Rupiah</div>

            <div class="stat-value">
                Rp {{ number_format($estimasiRupiah, 0, ',', '.') }}
            </div>

            <div class="stat-description">
                @if ($kurs)
                    Konversi dengan kurs
                    ¥1 = Rp {{ number_format((float) $kurs->rate, 2, ',', '.') }}
                @else
                    Kurs JPY ke IDR belum diatur
                @endif
            </div>
        </article>

        {{-- Total Resi --}}
        <article class="stat-card">
            <div class="stat-top">
                <div class="stat-icon gold">📦</div>
                <span class="section-caption">Resi</span>
            </div>

            <div class="stat-label">Total Resi</div>

            <div class="stat-value">
                {{ number_format($totalResi, 0, ',', '.') }}
            </div>

            <div class="stat-description">
                Resi barang yang sudah dicatat
            </div>
        </article>
    </div>
</section>

        <section>
            <div class="section-heading">
                <h3>Akses Cepat</h3>
                <span class="section-caption">Menu utama</span>
            </div>

            <div class="quick-grid">
                <a href="{{ route('purchase-orders.index') }}" class="quick-card">
                    <div class="quick-icon">🛍️</div>
                    <strong>Input Purchase</strong>
                    <span>Catat pesanan baru</span>
                </a>

                <a href="{{ route('arrived-items.index') }}" class="quick-card">
                    <div class="quick-icon">📦</div>
                    <strong>Input Arrived</strong>
                    <span>Input resi dan biaya</span>
                </a>

                <a href="{{ route('shipment-batches.recap') }}" class="quick-card">
                    <div class="quick-icon">🚚</div>
                    <strong>Rekap Pengiriman</strong>
                    <span>Kelola batch box</span>
                </a>

                <a href="/laporan" class="quick-card">
                    <div class="quick-icon">📊</div>
                    <strong>Laporan</strong>
                    <span>Lihat rekap transaksi</span>
                </a>
            </div>
        </section>

        
<section>
    <div class="section-heading">
        <h3>Aktivitas Terbaru</h3>
        <span class="section-caption">5 aktivitas terakhir</span>
    </div>

    <div class="activity-card">
        @forelse ($aktivitasTerbaru as $aktivitas)
            <div class="activity-item">
                <div class="activity-icon">
                    {{ $aktivitas['icon'] }}
                </div>

                <div class="activity-content">
                    <strong>{{ $aktivitas['judul'] }}</strong>
                    <p>{{ $aktivitas['keterangan'] }}</p>
                </div>

                <div class="activity-time">
                    {{ $aktivitas['tanggal']
                        ? \Carbon\Carbon::parse($aktivitas['tanggal'])->format('d/m/Y H:i')
                        : '-' }}
                </div>
            </div>
        @empty
            <div class="empty-state">
                <div class="empty-icon">📋</div>
                <strong>Belum ada aktivitas</strong>
                <p>Aktivitas pesanan, barang tiba, dan pengiriman akan tampil di sini.</p>
            </div>
        @endforelse
    </div>
</section>


        <footer class="footer">
            Milnkys · Japan Warehouse Manager
        </footer>
    </main>
</div>

<nav class="bottom-nav">
    <a href="/" class="bottom-link active">
        <span class="nav-icon">⌂</span>
        <span>Beranda</span>
    </a>
    <a href="{{ route('purchase-orders.index') }}" class="bottom-link">
    <span class="nav-icon">🛍</span>
    <span>Input Purchase</span>
</a>
    <a href="{{ route('arrived-items.index') }}" class="bottom-link">
        <span class="nav-icon">📦</span>
        <span>Input Arrived</span>
    </a>
    <a href="{{ route('shipment-batches.recap') }}" class="bottom-link">
        <span class="nav-icon">🚚</span>
        <span>Rekap Pengiriman</span>
    </a>
</nav>
<style>
    
.activity-card {
    background: var(--surface);
    border-radius: 20px;
    overflow: hidden;
}

.activity-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 14px 16px;
    border-bottom: 1px solid var(--border);
}

.activity-item:last-child {
    border-bottom: none;
}

.activity-icon {
    width: 42px;
    height: 42px;
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--primary-soft);
    border-radius: 14px;
    font-size: 20px;
}

.activity-content {
    flex: 1;
    min-width: 0;
}

.activity-content strong {
    display: block;
    font-size: 13px;
    color: var(--text);
}

.activity-content p {
    margin: 5px 0 0;
    font-size: 12px;
    color: var(--muted);
    overflow-wrap: anywhere;
}

.activity-time {
    flex-shrink: 0;
    font-size: 10px;
    color: var(--muted);
}

.empty-state {
    padding: 30px 16px;
    text-align: center;
    color: var(--muted);
}

.empty-icon {
    font-size: 28px;
    margin-bottom: 10px;
}

.empty-state strong {
    display: block;
    color: var(--text);
}

.empty-state p {
    font-size: 12px;
}
</style>

<style>
/* Tema biru modern Milnkys */
.nav-link:hover,
.profile-dropdown a:hover,
.profile-dropdown button:hover,
.profile-settings-toggle:hover,
.sidebar-note {
    background: var(--bg);
}
.nav-link.active,
.avatar,
.quick-icon,
.empty-icon,
.bottom-link.active .nav-icon {
    color: var(--primary-dark);
    background: var(--primary-soft);
}
.hero {
    background: linear-gradient(120deg, var(--primary-dark), var(--primary));
}
.stat-icon.green {
    color: var(--primary-dark);
    background: var(--primary-soft);
}
.activity-item {
    border-bottom-color: var(--border);
}
.activity-icon {
    color: var(--primary-dark);
    background: var(--primary-soft);
}
.activity-content strong,
.empty-state strong {
    color: var(--text);
}
.bottom-nav {
    border-top-color: var(--border);
}
</style>

<script>
    // Dropdown akun kanan atas: Pengaturan dan Logout
    const profileMenu = document.getElementById('profileMenu');
    const profileToggle = document.getElementById('profileToggle');
    const profileSettings = document.getElementById('profileSettings');
    const profileSettingsToggle = document.getElementById('profileSettingsToggle');

    if (profileSettings && profileSettingsToggle) {
        profileSettingsToggle.addEventListener('click', function (event) {
            event.stopPropagation();
            const isOpen = profileSettings.classList.toggle('open');
            profileSettingsToggle.setAttribute('aria-expanded', String(isOpen));
        });
    }

    if (profileMenu && profileToggle) {
        profileToggle.addEventListener('click', function () {
            const isOpen = profileMenu.classList.toggle('open');
            profileToggle.setAttribute('aria-expanded', String(isOpen));
        });

        document.addEventListener('click', function (event) {
            if (!profileMenu.contains(event.target)) {
                profileMenu.classList.remove('open');
                profileToggle.setAttribute('aria-expanded', 'false');
            }
        });
    }
</script>

</body>
</html>