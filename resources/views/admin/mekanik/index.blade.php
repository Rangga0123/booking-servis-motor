<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mekanik - Bengkel Royal Motor</title>

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
        .brand-subtitle { font-size: 10px; color: #aeb9cf; margin-top: 5px; }

        .sidebar-menu {
            padding: 27px 12px;
            flex: 1;
            overflow-y: auto;
        }

        .menu-link {
            min-height: 50px;
            padding: 0 20px;
            margin-bottom: 4px;
            border-radius: 11px;
            display: flex;
            align-items: center;
            gap: 19px;
            color: #f1f4fa;
            font-size: 14px;
            transition: background .22s ease, transform .22s ease;
            width: 100%;
        }

        .menu-link svg { width: 22px; height: 22px; flex-shrink: 0; }
        .menu-link:hover { background: #ffffff14; transform: translateX(3px); }

        .menu-link.active {
            background: linear-gradient(90deg, #3567d9, #355dbb);
            box-shadow: 0 7px 22px #305fd059;
        }

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
            transition: background .2s ease, transform .2s ease;
        }

        .mobile-menu { display: none; background: #f3f6fa; }

        .mobile-menu:hover, .desktop-menu:hover {
            background: #eaf0fa;
            transform: scale(1.04);
        }

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
        .profile-trigger[aria-expanded="true"] {
            background: #f2f6fc;
        }

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

        .profile-text strong {
            display: block;
            font-size: 13px;
            color: #182543;
        }

        .profile-text small {
            display: block;
            margin-top: 4px;
            font-size: 11px;
            color: #50658a;
        }

        .chevron {
            width: 15px;
            height: 15px;
            color: #7182a3;
            transition: transform .2s ease;
        }

        .profile-trigger[aria-expanded="true"] .chevron {
            transform: rotate(180deg);
        }

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

        .profile-dropdown.show {
            display: block;
            animation: dropIn .2s ease both;
        }

        @keyframes dropIn {
            from {
                opacity: 0;
                transform: translateY(-7px) scale(.98);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }

        .dropdown-heading {
            padding: 10px 11px 12px;
            border-bottom: 1px solid #edf1f7;
            margin-bottom: 5px;
        }

        .dropdown-heading strong {
            display: block;
            font-size: 13px;
        }

        .dropdown-heading small {
            display: block;
            color: #8290a8;
            font-size: 11px;
            margin-top: 4px;
        }

        .dropdown-link {
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 11px;
            border-radius: 8px;
            font-size: 12px;
            color: #344765;
            transition: background .18s ease, transform .18s ease;
        }

        .dropdown-link:hover {
            background: #f2f6fc;
            transform: translateX(2px);
        }

        .dropdown-link svg {
            width: 17px;
            height: 17px;
            color: #637795;
            flex-shrink: 0;
        }

        .dropdown-divider {
            height: 1px;
            background: #edf1f7;
            margin: 5px 0;
        }

        .dropdown-link.logout {
            width: 100%;
            border: 0;
            background: white;
            text-align: left;
            color: #dc4353;
        }

        .dropdown-link.logout:hover { background: #fff0f2; }

        .content {
            padding: 22px 25px 30px;
            max-width: 1600px;
            margin: auto;
        }

        .page-heading {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            flex-wrap: wrap;
            margin-bottom: 23px;
            animation: fadeUp .4s ease both;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .breadcrumb {
            font-size: 11px;
            color: #7182a3;
            margin-bottom: 9px;
        }

        .page-title {
            font-size: 27px;
            font-weight: 800;
            color: #14213d;
        }

        .page-description {
            font-size: 12px;
            color: #7182a3;
            margin-top: 8px;
            line-height: 1.6;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            border: 0;
            border-radius: 10px;
            padding: 12px 16px;
            font-size: 12px;
            font-weight: 700;
            transition: background .2s ease, transform .2s ease, box-shadow .2s ease;
        }

        .btn:hover { transform: translateY(-1px); }
        .btn-primary { background: #3264d8; color: white; box-shadow: 0 5px 14px #3264d82b; }
        .btn-primary:hover { background: #244fb5; }
        .btn-dark { background: #14213d; color: white; }
        .btn-dark:hover { background: #243b62; }
        .btn-light { border: 1px solid #dce5f1; background: white; color: #536682; }
        .btn-light:hover { background: #f5f8fc; }
        .btn-edit { background: #fff1dc; color: #a56808; padding: 9px 11px; }
        .btn-edit:hover { background: #ffe4b5; }
        .btn-delete { background: #ffe7eb; color: #d92f4d; padding: 9px 11px; }
        .btn-delete:hover { background: #ffd4db; }

        .notice {
            padding: 14px 16px;
            border-radius: 11px;
            margin-bottom: 17px;
            font-size: 12px;
            line-height: 1.7;
            animation: fadeUp .3s ease both;
        }

        .notice-success {
            background: #e8f8ef;
            color: #137849;
            border: 1px solid #bcebd0;
        }

        .notice-error {
            background: #fff0f2;
            color: #bd263e;
            border: 1px solid #ffd1d8;
        }

        .notice ul { margin-top: 6px; padding-left: 20px; }

        .stats {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 16px;
            margin-bottom: 19px;
        }

        .stat-card {
            background: white;
            border: 1px solid #dae3ee;
            border-radius: 14px;
            box-shadow: 0 5px 14px #273d630b;
            padding: 19px;
            display: flex;
            align-items: center;
            gap: 14px;
            transition: transform .22s ease, box-shadow .22s ease;
            animation: fadeUp .45s ease both;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 25px #20396215;
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .stat-blue { background: #e7efff; color: #3264d8; }
        .stat-green { background: #def6ed; color: #19a875; }
        .stat-label { font-size: 12px; color: #7182a3; font-weight: 700; }
        .stat-number { margin-top: 7px; font-size: 28px; font-weight: 800; color: #14213d; }

        .search-panel, .table-panel {
            background: white;
            border: 1px solid #dce5f1;
            border-radius: 14px;
            box-shadow: 0 5px 16px #273d630b;
            overflow: hidden;
            margin-bottom: 18px;
            animation: fadeUp .45s ease both;
        }

        .search-form {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            padding: 16px;
        }

        .search-input {
            flex: 1;
            min-width: 190px;
            border: 1px solid #d8e1ed;
            background: #fbfcfe;
            padding: 12px 14px;
            border-radius: 10px;
            outline: none;
            color: #243653;
            font-size: 12px;
            transition: border .2s ease, box-shadow .2s ease;
        }

        .search-input:focus {
            border-color: #3264d8;
            box-shadow: 0 0 0 3px #3264d81a;
            background: white;
        }

        .table-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding: 17px 19px;
            border-bottom: 1px solid #e5ebf3;
        }

        .table-title { font-size: 14px; font-weight: 800; }
        .table-subtitle { margin-top: 5px; font-size: 10px; color: #8392aa; }

        .table-wrapper { width: 100%; overflow-x: auto; }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
            min-width: 780px;
        }

        thead { background: #f5f8fc; color: #647795; }
        th { padding: 14px 16px; font-size: 10px; font-weight: 800; white-space: nowrap; }

        td {
            padding: 14px 16px;
            border-bottom: 1px solid #e7edf5;
            font-size: 11px;
            color: #465b7c;
            vertical-align: middle;
        }

        tbody tr { transition: background .18s ease; }
        tbody tr:hover { background: #f8faff; }
        tbody tr:last-child td { border-bottom: 0; }

        .mechanic-name { font-size: 12px; font-weight: 800; color: #1b2a47; }
        .mechanic-id { font-size: 10px; color: #94a1b6; margin-top: 5px; }

        .status {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 10px;
            border-radius: 30px;
            font-size: 10px;
            font-weight: 700;
            white-space: nowrap;
        }

        .status-active { color: #128253; background: #def6e9; }
        .status-inactive { color: #68758a; background: #edf0f5; }
        .actions { display: flex; flex-wrap: wrap; align-items: center; gap: 7px; }
        .delete-form { display: inline-flex; }

        .empty-state {
            padding: 40px 18px;
            text-align: center;
            color: #8190a8;
            font-size: 12px;
        }

        .table-footer {
            padding: 13px 18px;
            border-top: 1px solid #e7edf5;
            font-size: 10px;
            color: #8190a8;
            background: #fcfdff;
        }

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

        @media (min-width: 1001px) {
            .sidebar.collapsed { transform: translateX(-100%); }
            .main.sidebar-collapsed { margin-left: 0; }
        }

        @media (max-width: 1000px) {
            .sidebar { transform: translateX(-100%); box-shadow: none; }
            .sidebar.open {
                transform: translateX(0);
                box-shadow: 12px 0 35px #101b302b;
            }
            .main { margin-left: 0; }
            .mobile-menu { display: flex; }
            .desktop-menu { display: none; }
        }

        @media (max-width: 700px) {
            .topbar { height: 64px; padding: 0 12px; gap: 8px; }
            .profile-text { display: none; }
            .profile-trigger { gap: 5px; padding: 4px; }
            .avatar { width: 39px; height: 39px; }
            .profile-dropdown { right: 0; width: 220px; }
        }

        @media (max-width: 650px) {
            .content { padding: 17px 13px 25px; }
            .page-title { font-size: 23px; }
            .page-heading { align-items: flex-start; }
            .page-heading > .btn { width: 100%; }
            .stats { grid-template-columns: 1fr; gap: 11px; }
            .stat-card { padding: 15px; }
            .search-form { padding: 12px; }
            .search-input { min-width: 100%; flex-basis: 100%; }
            .search-form .btn { flex: 1; }
            .table-header { padding: 14px; }
        }

        @media (max-width: 380px) {
            .sidebar { width: 265px; }
        }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after {
                animation-duration: .01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: .01ms !important;
            }
        }
    </style>
</head>

<body>
@php
    $namaAdmin = auth()->user()->name ?? 'Admin';
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
        <a href="{{ route('admin.dashboard') }}" class="menu-link" onclick="tutupSidebarMobile()">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M3 11 12 4l9 7"/><path d="M5 10v10h14V10"/><path d="M9 20v-6h6v6"/>
            </svg>
            Dashboard
        </a>

        <a href="{{ route('admin.pelanggan-pesanan') }}" class="menu-link" onclick="tutupSidebarMobile()">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="7" r="4"/><path d="M4 21c0-4 3.6-7 8-7s8 3 8 7"/>
            </svg>
            Pelanggan &amp; Pesanan
        </a>

        <a href="{{ route('admin.mekanik.index') }}" class="menu-link active" onclick="tutupSidebarMobile()">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="9"/><path d="m8 12 3 3 5-6"/>
            </svg>
            Data Mekanik
        </a>

        <a href="{{ route('admin.informasi-bengkel.index') }}"
        class="menu-link"
        onclick="tutupSidebarMobile()">
            <svg viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2">
                <path d="M3 10.5 12 3l9 7.5"/>
                <path d="M5 9v12h14V9"/>
                <path d="M9 21v-7h6v7"/>
            </svg>
            Kelola Informasi Bengkel
        </a>

        <a href="#" class="menu-link" onclick="return menuBelumTersedia(event, 'Pembayaran')">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect x="3" y="5" width="18" height="14" rx="2"/><path d="M3 10h18M7 15h4"/>
            </svg>
            Pembayaran
        </a>

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
                aria-expanded="false" aria-controls="profileDropdown" onclick="toggleProfileDropdown()">
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
                    <small>Pengaturan akun</small>
                </div>

                <a href="{{ route('profile.edit') }}" class="dropdown-link">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="8" r="4"/><path d="M4 21c0-4 3.6-7 8-7s8 3 8 7"/>
                    </svg>
                    Profil Akun
                </a>

                <a href="{{ route('profile.edit') }}#profile-photo" class="dropdown-link">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="4" width="18" height="16" rx="2"/>
                        <circle cx="9" cy="10" r="2"/><path d="m21 15-5-5L5 20"/>
                    </svg>
                    Ganti Foto Profil
                </a>

                <a href="{{ route('profile.edit') }}#update-password" class="dropdown-link">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="4" y="10" width="16" height="11" rx="2"/>
                        <path d="M8 10V7a4 4 0 0 1 8 0v3"/>
                    </svg>
                    Ganti Password
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
        <section class="page-heading">
            <div>
                <div class="breadcrumb">Admin / Data Mekanik</div>
                <h1 class="page-title">Data Mekanik</h1>
                <p class="page-description">Kelola data mekanik Bengkel Royal Motor dengan mudah.</p>
            </div>

            <a href="{{ route('admin.mekanik.create') }}" class="btn btn-primary">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 5v14M5 12h14"/>
                </svg>
                Tambah Mekanik
            </a>
        </section>

        @if(session('success'))
            <div class="notice notice-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="notice notice-error">{{ session('error') }}</div>
        @endif

        @if($errors->any())
            <div class="notice notice-error">
                <strong>Periksa kembali data yang diisi.</strong>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <section class="stats">
            <div class="stat-card">
                <div class="stat-icon stat-blue">
                    <svg width="25" height="25" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="9" cy="8" r="4"/>
                        <path d="M2 21c0-4 3-7 7-7s7 3 7 7"/>
                        <path d="M16 5a4 4 0 0 1 0 7M18 14c2 .8 4 3 4 7"/>
                    </svg>
                </div>
                <div>
                    <div class="stat-label">Total Mekanik</div>
                    <div class="stat-number">{{ $mekaniks->count() }}</div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon stat-green">
                    <svg width="25" height="25" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="m5 12 4 4L19 6"/>
                    </svg>
                </div>
                <div>
                    <div class="stat-label">Mekanik Aktif</div>
                    <div class="stat-number">{{ $mekaniks->where('status', 'aktif')->count() }}</div>
                </div>
            </div>
        </section>

        <section class="search-panel">
            <form action="{{ route('admin.mekanik.index') }}" method="GET" class="search-form">
                <input
                    type="text"
                    name="cari"
                    value="{{ request('cari') }}"
                    placeholder="Cari nama atau spesialisasi mekanik..."
                    class="search-input"
                >

                <button type="submit" class="btn btn-dark">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="7"/>
                        <path d="m20 20-4-4"/>
                    </svg>
                    Cari
                </button>

                <a href="{{ route('admin.mekanik.index') }}" class="btn btn-light">Reset</a>
            </form>
        </section>

        <section class="table-panel">
            <div class="table-header">
                <div>
                    <div class="table-title">Daftar Mekanik</div>
                    <div class="table-subtitle">Data mekanik yang terdaftar di Bengkel Royal Motor.</div>
                </div>
            </div>

            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama Mekanik</th>
                            <th>Spesialisasi</th>
                            <th>Status</th>
                            <th>Pesanan Terkait</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($mekaniks as $mekanik)
                            <tr>
                                <td>{{ $loop->iteration }}</td>

                                <td>
                                    <div class="mechanic-name">{{ $mekanik->nama_mekanik }}</div>
                                    <div class="mechanic-id">ID Mekanik: #{{ $mekanik->id }}</div>
                                </td>

                                <td>{{ $mekanik->spesialisasi ?: '-' }}</td>

                                <td>
                                    @if($mekanik->status === 'aktif')
                                        <span class="status status-active">● Aktif</span>
                                    @else
                                        <span class="status status-inactive">● Nonaktif</span>
                                    @endif
                                </td>

                                <td>{{ $mekanik->bookings_count ?? 0 }}</td>

                                <td>
                                    <div class="actions">
                                        <a href="{{ route('admin.mekanik.edit', $mekanik->id) }}" class="btn btn-edit">
                                            Edit
                                        </a>

                                        <form
                                            action="{{ route('admin.mekanik.destroy', $mekanik->id) }}"
                                            method="POST"
                                            class="delete-form"
                                            onsubmit="return confirm('Yakin ingin menghapus mekanik ini?')"
                                        >
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn btn-delete">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">
                                    <div class="empty-state">
                                        <div style="font-size: 28px; margin-bottom: 10px;">♧</div>
                                        <strong>Belum ada data mekanik</strong>
                                        <p style="margin-top: 7px;">Tekan tombol Tambah Mekanik untuk menambahkan data baru.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="table-footer">
                Total {{ $mekaniks->count() }} data mekanik ditampilkan.
            </div>
        </section>
    </main>
</div>

<script>
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
</body>
</html>