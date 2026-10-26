<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') - Bengkel Royal Motor</title>

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        html { scroll-behavior: smooth; }

        :root {
            --sidebar: #14213d;
            --blue: #3264d8;
            --bg: #f4f7fb;
            --text: #14213d;
            --muted: #7182a3;
            --border: #dce5f1;
        }

        body {
            min-height: 100vh;
            font-family: Arial, Helvetica, sans-serif;
            background: var(--bg);
            color: var(--text);
        }

        a { color: inherit; text-decoration: none; }
        button, input, select { font: inherit; }
        button { cursor: pointer; }

        /* SIDEBAR */
        .sidebar {
            position: fixed;
            inset: 0 auto 0 0;
            width: 278px;
            background: linear-gradient(180deg, #172541, #121c34);
            color: white;
            z-index: 1000;
            display: flex;
            flex-direction: column;
            transition: transform .3s ease, box-shadow .3s ease;
        }

        .sidebar-brand {
            min-height: 72px;
            display: flex;
            align-items: center;
            padding: 0 29px;
            border-bottom: 1px solid #ffffff14;
        }

        .brand-title { font-size: 16px; font-weight: 800; }
        .brand-subtitle { font-size: 11px; color: #aeb9cf; margin-top: 5px; }

        .sidebar-menu { padding: 24px 12px; flex: 1; overflow-y: auto; }

        .menu-link {
            min-height: 48px;
            padding: 0 18px;
            margin-bottom: 4px;
            border-radius: 11px;
            display: flex;
            align-items: center;
            gap: 16px;
            color: #f1f4fa;
            font-size: 14px;
            width: 100%;
            transition: background .22s ease;
        }

        .menu-link svg { width: 21px; height: 21px; flex-shrink: 0; }
        .menu-link:hover { background: #ffffff14; }

        .menu-link.active {
            background: linear-gradient(90deg, #3567d9, #355dbb);
            box-shadow: 0 7px 22px #305fd059;
        }

        .menu-link.has-sub {
            border: 0;
            background: transparent;
            text-align: left;
        }

        .menu-link.has-sub:hover { background: #ffffff14; }

        .menu-arrow {
            margin-left: auto;
            width: 16px !important;
            height: 16px !important;
            transition: transform .25s ease;
            transform: rotate(-90deg);
        }

        .menu-group.open .menu-arrow { transform: rotate(0deg); }
        .menu-group.open > .has-sub { background: #ffffff1f; }

        .submenu {
            max-height: 0;
            overflow: hidden;
            transition: max-height .3s ease;
        }

        .menu-group.open .submenu {
            max-height: 400px;
            padding: 6px 0 4px;
        }

        .submenu-link {
            display: flex;
            align-items: center;
            min-height: 42px;
            padding: 0 18px 0 55px;
            margin-bottom: 2px;
            border-radius: 10px;
            font-size: 13px;
            color: #cfd8ea;
            transition: background .2s ease;
        }

        .submenu-link:hover { background: #ffffff14; }

        .submenu-link.active {
            background: linear-gradient(90deg, #3567d9, #355dbb);
            color: white;
            font-weight: 700;
        }

        /* MAIN DAN TOPBAR */
        .main {
            margin-left: 278px;
            min-height: 100vh;
            transition: margin-left .3s ease;
        }

        .topbar {
            height: 72px;
            background: #fffffff5;
            border-bottom: 1px solid #e7edf5;
            display: flex;
            align-items: center;
            padding: 0 25px;
            position: sticky;
            top: 0;
            z-index: 800;
            gap: 15px;
            backdrop-filter: blur(12px);
        }

        .mobile-menu, .desktop-menu {
            width: 40px;
            height: 40px;
            border: 0;
            border-radius: 9px;
            background: transparent;
            color: #243653;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background .2s ease;
        }

        .mobile-menu { display: none; background: #f3f6fa; }

        .mobile-menu:hover, .desktop-menu:hover { background: #eaf0fa; }
        .topbar-spacer { flex: 1; }
        .profile-wrap { position: relative; }

        .profile-trigger {
            display: flex;
            align-items: center;
            gap: 10px;
            border: 0;
            background: transparent;
            padding: 6px 9px;
            border-radius: 12px;
            text-align: left;
            transition: background .2s ease;
        }

        .profile-trigger:hover,
        .profile-trigger[aria-expanded="true"] { background: #f2f6fc; }

        .avatar {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: linear-gradient(135deg, #d9e6ff, #9ebcff);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            color: #224c9c;
            overflow: hidden;
            flex-shrink: 0;
        }

        .profile-text strong { display: block; font-size: 14px; color: #182543; }
        .profile-text small { display: block; margin-top: 4px; font-size: 12px; color: #50658a; }

        .chevron {
            width: 15px;
            height: 15px;
            color: #7182a3;
            transition: transform .2s ease;
        }

        .profile-trigger[aria-expanded="true"] .chevron { transform: rotate(180deg); }

        .profile-dropdown {
            display: none;
            position: absolute;
            right: 0;
            top: calc(100% + 9px);
            width: 225px;
            background: white;
            border: 1px solid #e0e7f1;
            border-radius: 13px;
            padding: 8px;
            box-shadow: 0 16px 40px #17254120;
            z-index: 1200;
        }

        .profile-dropdown.show { display: block; animation: dropIn .2s ease both; }

        @keyframes dropIn {
            from { opacity: 0; transform: translateY(-7px) scale(.98); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .dropdown-heading {
            padding: 10px 11px 12px;
            border-bottom: 1px solid #edf1f7;
            margin-bottom: 5px;
        }

        .dropdown-heading strong { display: block; font-size: 13px; }
        .dropdown-heading small { display: block; color: #8290a8; font-size: 12px; margin-top: 4px; }

        .dropdown-link {
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 11px;
            border-radius: 8px;
            font-size: 13px;
            color: #344765;
            transition: background .18s ease;
        }

        .dropdown-link:hover { background: #f2f6fc; }
        .dropdown-link svg { width: 17px; height: 17px; color: #637795; flex-shrink: 0; }
        .dropdown-divider { height: 1px; background: #edf1f7; margin: 5px 0; }

        .dropdown-link.logout {
            width: 100%;
            border: 0;
            background: white;
            text-align: left;
            color: #dc4353;
        }

        .dropdown-link.logout:hover { background: #fff0f2; }

        /* KONTEN */
        .content {
            padding: 26px 28px 34px;
            max-width: 1600px;
            margin: auto;
        }

        .page-heading {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            flex-wrap: wrap;
            margin-bottom: 24px;
        }

        .breadcrumb { font-size: 12px; color: var(--muted); margin-bottom: 9px; }
        .page-title { font-size: 28px; font-weight: 800; color: var(--text); }
        .page-description { font-size: 14px; color: var(--muted); margin-top: 8px; line-height: 1.6; }

        /* TOMBOL */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            border: 0;
            border-radius: 10px;
            padding: 12px 18px;
            font-size: 13px;
            font-weight: 700;
            transition: background .2s ease, box-shadow .2s ease;
        }

        .btn-primary { background: var(--blue); color: white; box-shadow: 0 5px 14px #3264d82b; }
        .btn-primary:hover { background: #244fb5; }
        .btn-dark { background: var(--text); color: white; }
        .btn-dark:hover { background: #243b62; }
        .btn-light { border: 1px solid var(--border); background: white; color: #536682; }
        .btn-light:hover { background: #f5f8fc; }

        .btn-sm { padding: 8px 14px; font-size: 12px; border-radius: 8px; }
        .btn-edit { background: #f5a524; color: #3b2600; }
        .btn-edit:hover { background: #e19410; }
        .btn-delete { background: #e5384f; color: white; }
        .btn-delete:hover { background: #c92a40; }

        /* NOTIFIKASI */
        .notice { padding: 14px 16px; border-radius: 11px; margin-bottom: 18px; font-size: 13px; line-height: 1.7; }
        .notice-success { background: #e8f8ef; color: #137849; border: 1px solid #bcebd0; }
        .notice-error { background: #fff0f2; color: #bd263e; border: 1px solid #ffd1d8; }
        .notice ul { margin-top: 6px; padding-left: 20px; }

        /* STATISTIK */
        .stats {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 16px;
            margin-bottom: 20px;
        }

        .stat-card {
            background: white;
            border: 1px solid #dae3ee;
            border-radius: 14px;
            box-shadow: 0 5px 14px #273d630b;
            padding: 20px;
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .stat-icon {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .stat-blue { background: #e7efff; color: var(--blue); }
        .stat-green { background: #def6ed; color: #19a875; }
        .stat-label { font-size: 13px; color: var(--muted); font-weight: 700; }
        .stat-number { margin-top: 6px; font-size: 30px; font-weight: 800; color: var(--text); }

        /* PANEL */
        .panel {
            background: white;
            border: 1px solid var(--border);
            border-radius: 14px;
            box-shadow: 0 5px 16px #273d630b;
            overflow: hidden;
            margin-bottom: 20px;
        }

        .search-form { display: flex; flex-wrap: wrap; gap: 10px; padding: 16px; }

        .search-input {
            flex: 1;
            min-width: 190px;
            border: 1px solid #d8e1ed;
            background: #fbfcfe;
            padding: 12px 14px;
            border-radius: 10px;
            outline: none;
            color: #243653;
            font-size: 14px;
            transition: border .2s ease, box-shadow .2s ease;
        }

        .search-input:focus {
            border-color: var(--blue);
            box-shadow: 0 0 0 3px #3264d81a;
            background: white;
        }

        .panel-header { padding: 18px 22px; border-bottom: 1px solid #e5ebf3; }
        .panel-title { font-size: 17px; font-weight: 800; }
        .panel-subtitle { margin-top: 5px; font-size: 13px; color: #8392aa; }

        /* TABEL */
        .table-wrapper { width: 100%; overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; text-align: left; min-width: 780px; }
        thead { background: #eaf0fa; }

        th {
            padding: 15px 20px;
            font-size: 13px;
            font-weight: 800;
            color: #2a3c5e;
            white-space: nowrap;
            border-bottom: 2px solid #d3deee;
        }

        td {
            padding: 16px 20px;
            border-bottom: 1px solid #e7edf5;
            font-size: 14px;
            color: #3c5070;
            vertical-align: middle;
        }

        tbody tr:nth-child(even) { background: #f8fafd; }
        tbody tr:hover { background: #eef4ff; }
        tbody tr:last-child td { border-bottom: 0; }
        .col-no { width: 70px; text-align: center; }
        .mechanic-name { font-size: 15px; font-weight: 800; color: #1b2a47; }
        .mechanic-id { font-size: 12px; color: #94a1b6; margin-top: 5px; }

        .status {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            border-radius: 30px;
            font-size: 12px;
            font-weight: 700;
            white-space: nowrap;
        }

        .status-active { color: #0f7a4d; background: #d6f5e5; }
        .status-inactive { color: #5f6c82; background: #e6eaf1; }
        .actions { display: flex; flex-wrap: wrap; align-items: center; gap: 8px; }
        .delete-form { display: inline-flex; }
        .empty-state { padding: 44px 18px; text-align: center; color: #8190a8; font-size: 14px; }

        .table-footer {
            padding: 14px 22px;
            border-top: 1px solid #e7edf5;
            font-size: 13px;
            color: #8190a8;
            background: #fcfdff;
        }

        /* FORM */
        .form-card { max-width: 720px; padding: 28px; }
        .form-grid { display: grid; gap: 20px; margin-top: 24px; }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
            font-weight: 700;
            color: #1b2a47;
        }

        .form-control {
            width: 100%;
            border: 1px solid #d8e1ed;
            background: #fbfcfe;
            padding: 13px 15px;
            border-radius: 10px;
            outline: none;
            color: #243653;
            font-size: 14px;
            transition: border .2s ease, box-shadow .2s ease;
        }

        .form-control:focus {
            border-color: var(--blue);
            box-shadow: 0 0 0 3px #3264d81a;
            background: white;
        }

        .form-actions { display: flex; flex-wrap: wrap; gap: 10px; padding-top: 6px; }

        /* OVERLAY DAN RESPONSIF */
        .overlay { display: none; }

        .overlay.show {
            display: block;
            position: fixed;
            inset: 0;
            background: #0a142873;
            z-index: 900;
            animation: fadeIn .2s ease;
        }

        .sidebar.collapsed { transform: translateX(-100%); }
        .main.sidebar-collapsed { margin-left: 0; }

        @media (max-width: 1000px) {
            .sidebar { transform: translateX(-100%); box-shadow: none; }
            .sidebar.open { transform: translateX(0); box-shadow: 12px 0 35px #101b302b; }
            .main { margin-left: 0; }
            .mobile-menu { display: flex; }
            .desktop-menu { display: none; }
        }

        @media (max-width: 700px) {
            .topbar { height: 64px; padding: 0 12px; gap: 8px; }
            .profile-text { display: none; }
            .profile-trigger { gap: 5px; padding: 4px; }
            .avatar { width: 39px; height: 39px; }
        }

        @media (max-width: 650px) {
            .content { padding: 18px 13px 26px; }
            .page-title { font-size: 24px; }
            .page-heading > .btn { width: 100%; }
            .stats { grid-template-columns: 1fr; gap: 11px; }
            .search-input { min-width: 100%; flex-basis: 100%; }
            .search-form .btn { flex: 1; }
            .form-card { padding: 20px; }
        }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after {
                animation-duration: .01ms !important;
                transition-duration: .01ms !important;
            }
        }
    </style>

    @stack('styles')
</head>

<body>
@php
    $namaAdmin = auth()->user()->name ?? 'Admin';

    // Data Master terbuka saat salah satu halaman di dalamnya aktif
    $masterAktif = request()->routeIs('admin.mekanik.*')
        || request()->routeIs('admin.informasi-bengkel.*')
        || request()->routeIs('admin.layanan.*');

    // Pelanggan terbuka saat daftar pesanan atau jadwal servis aktif
    $pesananAktif = request()->routeIs('admin.pelanggan-pesanan*')
        || request()->routeIs('admin.jadwal-servis*');
@endphp

<div id="overlay" class="overlay" onclick="tutupSidebarMobile()"></div>

<aside id="sidebar" class="sidebar">
    <div class="sidebar-brand">
        <div>
            <div class="brand-title">Bengkel Royal Motor</div>
            <div class="brand-subtitle">Servis Motor, Solusi Perjalananmu</div>
        </div>
    </div>

    <nav class="sidebar-menu">
        {{-- DASHBOARD --}}
        <a href="{{ route('admin.dashboard') }}"
           class="menu-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
           onclick="tutupSidebarMobile()">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M3 11 12 4l9 7"/><path d="M5 10v10h14V10"/><path d="M9 20v-6h6v6"/>
            </svg>
            Dashboard
        </a>

        {{-- PELANGGAN DAN PESANAN --}}
        <div class="menu-group {{ $pesananAktif ? 'open' : '' }}">
            <button type="button" class="menu-link has-sub" onclick="toggleSubmenu(this)">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="7" r="4"/>
                    <path d="M4 21c0-4 3.6-7 8-7s8 3 8 7"/>
                </svg>
                Pelanggan
                <svg class="menu-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="m6 9 6 6 6-6"/>
                </svg>
            </button>

            <div class="submenu">
                <a href="{{ route('admin.pelanggan-pesanan') }}"
                   class="submenu-link {{ request()->routeIs('admin.pelanggan-pesanan*') ? 'active' : '' }}"
                   onclick="tutupSidebarMobile()">
                    Daftar Pesanan
                </a>

                <a href="{{ route('admin.jadwal-servis') }}"
                   class="submenu-link {{ request()->routeIs('admin.jadwal-servis*') ? 'active' : '' }}"
                   onclick="tutupSidebarMobile()">
                    Jadwal Servis
                </a>
            </div>
        </div>

        {{-- DATA MASTER --}}
        <div class="menu-group {{ $masterAktif ? 'open' : '' }}">
            <button type="button" class="menu-link has-sub" onclick="toggleSubmenu(this)">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="4" width="18" height="6" rx="1"/>
                    <rect x="3" y="14" width="18" height="6" rx="1"/>
                </svg>
                Data Master
                <svg class="menu-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="m6 9 6 6 6-6"/>
                </svg>
            </button>

            <div class="submenu">
                <a href="{{ route('admin.mekanik.index') }}"
                   class="submenu-link {{ request()->routeIs('admin.mekanik.*') ? 'active' : '' }}"
                   onclick="tutupSidebarMobile()">
                    Data Mekanik
                </a>

                <a href="{{ route('admin.informasi-bengkel.index') }}"
                   class="submenu-link {{ request()->routeIs('admin.informasi-bengkel.*') ? 'active' : '' }}"
                   onclick="tutupSidebarMobile()">
                    Informasi Bengkel
                </a>

                {{-- MENU BARU: KELOLA LAYANAN DAN HARGA --}}
                
                <a href="{{ route('admin.layanan.index') }}"
                class="submenu-link {{ request()->routeIs('admin.layanan.*') ? 'active' : '' }}"
                onclick="tutupSidebarMobile()">
                    Kelola Layanan &amp; Harga
                </a>

            </div>
        </div>

        {{-- PEMBAYARAN --}}
        <a href="#" class="menu-link" onclick="return menuBelumTersedia(event, 'Pembayaran')">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect x="3" y="5" width="18" height="14" rx="2"/>
                <path d="M3 10h18M7 15h4"/>
            </svg>
            Pembayaran
        </a>

        {{-- LAPORAN --}}
        <a href="#" class="menu-link" onclick="return menuBelumTersedia(event, 'Laporan')">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M4 19V5M4 19h16M8 16v-5M12 16V8M16 16v-9"/>
            </svg>
            Laporan
        </a>
    </nav>
</aside>

<div class="main">
    <header class="topbar">
        <button type="button" class="mobile-menu" onclick="toggleSidebar()" aria-label="Buka menu">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>

        <button type="button" class="desktop-menu" onclick="toggleSidebar()" aria-label="Tampilkan atau sembunyikan menu">
            <svg width="21" height="21" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M4 6h16M4 12h10M4 18h16"/>
            </svg>
        </button>

        <div class="topbar-spacer"></div>

        <div class="profile-wrap" id="profileWrap">
            <button type="button" class="profile-trigger" id="profileTrigger"
                    aria-expanded="false" aria-controls="profileDropdown"
                    onclick="toggleProfileDropdown()">
                <div class="avatar">
                    @if(auth()->user()->profile_photo_url)
                        <img src="{{ auth()->user()->profile_photo_url }}" alt="Foto profil"
                             style="width:100%;height:100%;object-fit:cover">
                    @else
                        {{ strtoupper(substr($namaAdmin, 0, 1)) }}
                    @endif
                </div>

                <div class="profile-text">
                    <strong>{{ $namaAdmin }}</strong>
                    <small>Administrator</small>
                </div>

                <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="m6 9 6 6 6-6"/>
                </svg>
            </button>

            <div class="profile-dropdown" id="profileDropdown">
                <div class="dropdown-heading">
                    <strong>{{ $namaAdmin }}</strong>
                    <small>Akun Administrator</small>
                </div>

                <a href="{{ route('profile.edit') }}" class="dropdown-link">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="8" r="4"/>
                        <path d="M4 21c0-4 3.6-7 8-7s8 3 8 7"/>
                    </svg>
                    Profil Akun
                </a>

                <div class="dropdown-divider"></div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="dropdown-link logout">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M10 17l5-5-5-5M15 12H3M21 19V5a2 2 0 0 0-2-2h-6"/>
                        </svg>
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </header>

    <main class="content">
        @yield('content')
    </main>
</div>

<script>
    function toggleSubmenu(btn) {
        btn.parentElement.classList.toggle('open');
    }

    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const main = document.querySelector('.main');
        const overlay = document.getElementById('overlay');

        if (window.innerWidth <= 1000) {
            const isOpen = sidebar.classList.toggle('open');
            overlay.classList.toggle('show', isOpen);
            document.body.style.overflow = isOpen ? 'hidden' : '';
        } else {
            const isCollapsed = sidebar.classList.toggle('collapsed');
            main.classList.toggle('sidebar-collapsed', isCollapsed);
            overlay.classList.remove('show');
            document.body.style.overflow = '';
        }
    }

    function tutupSidebarMobile() {
        if (window.innerWidth <= 1000) {
            document.getElementById('sidebar').classList.remove('open');
            document.getElementById('overlay').classList.remove('show');
            document.body.style.overflow = '';
        }
    }

    window.addEventListener('resize', function () {
        const sidebar = document.getElementById('sidebar');
        const main = document.querySelector('.main');
        const overlay = document.getElementById('overlay');

        if (window.innerWidth > 1000) {
            sidebar.classList.remove('open');
            overlay.classList.remove('show');
            document.body.style.overflow = '';
        } else {
            sidebar.classList.remove('collapsed');
            main.classList.remove('sidebar-collapsed');
        }
    });

    function toggleProfileDropdown() {
        const dropdown = document.getElementById('profileDropdown');
        const trigger = document.getElementById('profileTrigger');
        const isOpen = dropdown.classList.toggle('show');
        trigger.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
    }

    function closeProfileDropdown() {
        const dropdown = document.getElementById('profileDropdown');
        const trigger = document.getElementById('profileTrigger');

        if (dropdown) dropdown.classList.remove('show');
        if (trigger) trigger.setAttribute('aria-expanded', 'false');
    }

    document.addEventListener('click', function (event) {
        const wrap = document.getElementById('profileWrap');
        if (wrap && !wrap.contains(event.target)) {
            closeProfileDropdown();
        }
    });

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            closeProfileDropdown();
            tutupSidebarMobile();
        }
    });

    function menuBelumTersedia(event, nama) {
        event.preventDefault();
        tutupSidebarMobile();
        alert('Halaman ' + nama + ' belum memiliki route. Halaman ini perlu dibuat terlebih dahulu.');
        return false;
    }
</script>

@stack('scripts')
</body>
</html>