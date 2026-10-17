<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Bengkel Royal Motor</title>

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --sidebar: #14213d;
            --blue: #3264d8;
            --border: #dce5f1;
            --text: #14213d;
            --muted: #7182a3;
            --bg: #f4f7fb;
            --green: #19a875;
            --red: #f23d5e;
            --orange: #f7a11a;
        }

        html { scroll-behavior: smooth; }

        body {
            font-family: Arial, Helvetica, sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
        }

        button, input, select { font: inherit; }
        button { cursor: pointer; }
        a { color: inherit; text-decoration: none; }

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

        .sidebar.collapsed { transform: translateX(-100%); }

        .main {
            margin-left: 278px;
            min-height: 100vh;
            transition: margin-left .3s ease;
        }

        .main.sidebar-collapsed { margin-left: 0; }

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

        .profile-text strong { display: block; font-size: 13px; color: #182543; }
        .profile-text small { display: block; margin-top: 4px; font-size: 11px; color: #50658a; }

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

        .dropdown-heading {
            padding: 10px 11px 12px;
            border-bottom: 1px solid #edf1f7;
            margin-bottom: 5px;
        }

        .dropdown-heading strong { display: block; font-size: 13px; }
        .dropdown-heading small { display: block; color: #8290a8; font-size: 11px; margin-top: 4px; }

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

        .dropdown-link:hover { background: #f2f6fc; transform: translateX(2px); }
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

        .content { padding: 20px 25px 28px; max-width: 1600px; margin: auto; }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(12px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }

        .welcome, .stat-card, .panel { animation: fadeUp .45s ease both; }
        .stat-card:nth-child(2) { animation-delay: .07s; }
        .stat-card:nth-child(3) { animation-delay: .14s; }
        .dashboard-grid > .panel:nth-child(2) { animation-delay: .08s; }

        .welcome {
            min-height: 100px;
            border: 1px solid #c7ddfa;
            border-radius: 14px;
            background: linear-gradient(110deg, #c3d8ff, #dff4ff);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
            padding: 16px 22px;
            margin-bottom: 16px;
            box-shadow: 0 5px 16px #325da40b;
        }

        .welcome-left { display: flex; align-items: center; gap: 15px; }

        .welcome-hand {
            width: 48px;
            height: 48px;
            border-radius: 13px;
            background: #ffffffa8;
            color: #2d5eb8;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .welcome h1 { font-size: 24px; color: #102143; line-height: 1.3; }
        .welcome p { margin-top: 6px; font-size: 12px; color: #3d5790; line-height: 1.5; }

        .date-box {
            min-width: 230px;
            background: #ffffffc9;
            border: 1px solid #b8d3f2d9;
            border-radius: 13px;
            padding: 12px 14px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .date-icon {
            width: 38px;
            height: 38px;
            border-radius: 11px;
            background: #e5efff;
            color: #3b65bc;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .date-text { font-size: 11px; color: #46618e; margin-bottom: 5px; }
        .time-text { font-size: 16px; font-weight: 800; font-variant-numeric: tabular-nums; }

        .stats {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 16px;
            margin-bottom: 16px;
        }

        .stat-card {
            min-height: 120px;
            background: white;
            border-radius: 14px;
            border: 1px solid #dae3ee;
            box-shadow: 0 5px 14px #273d630f;
            padding: 17px;
            display: flex;
            align-items: flex-start;
            transition: transform .25s ease, box-shadow .25s ease, border-color .25s ease;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 13px 28px #20396218;
            border-color: #c8d8ee;
        }

        .stat-icon {
            width: 51px;
            height: 51px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 14px;
            flex-shrink: 0;
            transition: transform .25s ease;
        }

        .stat-card:hover .stat-icon { transform: scale(1.06); }
        .stat-blue .stat-icon { color: #3580ff; background: #e2eeff; }
        .stat-orange .stat-icon { color: #ff8d11; background: #fff1dc; }
        .stat-green .stat-icon { color: #12a77b; background: #def6ed; }
        .stat-orange { border-bottom: 2px solid #f7a11a; }
        .stat-green { border-bottom: 2px solid #21b989; }
        .stat-title { font-size: 13px; font-weight: 700; }
        .stat-number { font-size: 29px; margin-top: 8px; font-weight: 800; }
        .stat-description { font-size: 10px; margin-top: 7px; color: #4c689b; }

        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 16px;
            align-items: start;
        }

        .panel {
            background: white;
            border: 1px solid #d8e1ed;
            border-radius: 14px;
            box-shadow: 0 5px 16px #273d630d;
            overflow: hidden;
            min-width: 0;
        }

        .panel-header { padding: 15px 18px 14px; border-bottom: 1px solid #e4eaf2; }
        .panel-heading { display: flex; align-items: flex-start; gap: 12px; }

        .panel-heading-icon {
            width: 40px;
            height: 40px;
            border-radius: 11px;
            background: linear-gradient(135deg, #3468d5, #355eb8);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .panel-title { font-size: 16px; font-weight: 800; }
        .panel-subtitle { margin-top: 5px; font-size: 11px; color: #7890b9; line-height: 1.5; }

        .summary-content { padding: 17px; }

        .summary-item {
            display: flex;
            align-items: center;
            gap: 13px;
            padding: 15px 13px;
            border: 1px solid #e3eaf3;
            border-radius: 11px;
            margin-bottom: 12px;
            transition: transform .2s ease, box-shadow .2s ease;
        }

        .summary-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 7px 17px #20396212;
        }

        .summary-icon {
            width: 45px;
            height: 45px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .summary-blue { background: #e7efff; color: #3264d8; }
        .summary-orange { background: #fff1dc; color: #e99516; }
        .summary-green { background: #def6ed; color: #19a875; }
        .summary-red { background: #ffe7eb; color: #e54860; }
        .summary-label { font-size: 12px; font-weight: 700; color: #526585; }
        .summary-number { margin-top: 5px; font-size: 25px; font-weight: 800; color: #14213d; }
        .summary-description { margin-top: 5px; font-size: 10px; color: #8190a8; }

        .summary-link {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            margin-top: 15px;
            padding: 12px 14px;
            border-radius: 9px;
            background: #f0f5ff;
            color: #3264d8;
            font-size: 11px;
            font-weight: 700;
            transition: background .2s ease, transform .2s ease;
        }

        .summary-link:hover { background: #e2ebff; transform: translateX(2px); }

        .activity-panel { grid-column: 1 / -1; }

        .table-wrapper { overflow-x: auto; }

        .booking-table { width: 100%; border-collapse: collapse; min-width: 540px; }

        .booking-table th {
            height: 43px;
            padding: 0 14px;
            background: #f5f8fc;
            border-bottom: 1px solid #dfe7f1;
            font-size: 10px;
            text-align: left;
            white-space: nowrap;
        }

        .booking-table td {
            padding: 14px;
            border-bottom: 1px solid #e3eaf3;
            vertical-align: middle;
            font-size: 11px;
            color: #41577b;
        }

        .booking-table tbody tr { transition: background .2s ease; }
        .booking-table tbody tr:hover { background: #fbfdff; }
        .customer-name { font-size: 12px; color: #17243f; font-weight: 800; }
        .customer-detail { display: block; margin-top: 5px; color: #43628f; font-size: 10px; }

        .status {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            border-radius: 20px;
            padding: 6px 9px;
            font-size: 9px;
            font-weight: 700;
            white-space: nowrap;
        }

        .waiting { background: #fff2d7; color: #ec9400; }
        .process { background: #e8f1ff; color: #326fea; }
        .done { background: #def6eb; color: #15986d; }
        .rejected { background: #ffe5e9; color: #d92f4d; }

        .empty-state { padding: 35px 15px; text-align: center; color: #8393ae; font-size: 11px; }

        .table-footer {
            padding: 13px 17px;
            color: #7184a8;
            font-size: 10px;
            display: flex;
            justify-content: space-between;
            gap: 10px;
            flex-wrap: wrap;
        }

        .table-footer a { color: #3264d8; font-weight: 700; }

        .overlay { display: none; }

        .overlay.show {
            display: block;
            position: fixed;
            inset: 0;
            background: #0a142873;
            z-index: 900;
            animation: fadeIn .2s ease;
        }

        @media (max-width: 1250px) {
            .dashboard-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        }

        @media (max-width: 1000px) {
            .sidebar { transform: translateX(-100%); box-shadow: none; }
            .sidebar.open { transform: translateX(0); box-shadow: 12px 0 35px #101b302b; }
            .main { margin-left: 0; }
            .mobile-menu { display: flex; }
            .desktop-menu { display: none; }
        }

        @media (min-width: 1001px) {
            .sidebar.collapsed { transform: translateX(-100%); }
            .main.sidebar-collapsed { margin-left: 0; }
        }

        @media (max-width: 700px) {
            .topbar { height: 64px; padding: 0 12px; gap: 8px; }
            .content { padding: 14px; }
            .profile-text { display: none; }
            .profile-trigger { gap: 5px; padding: 4px; }
            .avatar { width: 39px; height: 39px; }
            .welcome { align-items: stretch; flex-direction: column; padding: 17px; }
            .welcome h1 { font-size: 20px; }
            .welcome p { font-size: 12px; }
            .date-box { width: 100%; min-width: 0; }
            .stats { grid-template-columns: 1fr; gap: 11px; }
            .stat-card { min-height: 105px; }
            .dashboard-grid { grid-template-columns: minmax(0, 1fr); }
            .activity-panel { grid-column: auto; }
            .summary-content { padding: 12px; }
            .summary-item { padding: 12px 10px; }
            .profile-dropdown { right: 0; width: 220px; }
            .panel-header { padding: 13px; }
            .panel-title { font-size: 14px; }
            .panel-subtitle { font-size: 10px; }
        }

        @media (max-width: 380px) {
            .sidebar { width: 265px; }
            .welcome h1 { font-size: 18px; }
            .welcome-left { align-items: flex-start; }
        }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after {
                animation-duration: .01ms !important;
                animation-iteration-count: 1 !important;
                scroll-behavior: auto !important;
                transition-duration: .01ms !important;
            }
        }
    </style>
</head>

<body>
@php
    $totalBooking = $bookings->count();

    $bookingMenunggu = $bookings->filter(function ($booking) {
        return in_array(strtolower($booking->status ?? ''), ['menunggu', 'pending']);
    })->count();

    $servisSelesai = $bookings->filter(function ($booking) {
        return strtolower($booking->status ?? '') === 'selesai';
    })->count();

    $namaAdmin = auth()->user()->name ?? 'Admin';

    $tanggalHariIni = now()->toDateString();

    $bookingHariIni = $bookings->filter(function ($item) use ($tanggalHariIni) {
        return $item->tanggal_booking &&
            \Carbon\Carbon::parse($item->tanggal_booking)->toDateString() === $tanggalHariIni;
    })->count();

    $mekanikAktif = $mechanics->filter(function ($item) {
        return strtolower($item->status ?? '') === 'aktif';
    })->count();

    $mekanikNonaktif = $mechanics->filter(function ($item) {
        return strtolower($item->status ?? '') === 'nonaktif';
    })->count();

    $aktivitasTerbaru = $bookings->sortByDesc('created_at')->take(5);
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
        <a href="{{ route('admin.dashboard') }}" class="menu-link active" onclick="tutupSidebarMobile()">
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

        <a href="{{ route('admin.mekanik.index') }}" class="menu-link" onclick="tutupSidebarMobile()">
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
        <section class="welcome">
            <div class="welcome-left">
                <div class="welcome-hand" aria-hidden="true">
                    <svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M4 19V5M4 19h16"/><path d="m7 15 4-4 3 2 5-6"/><path d="M16 7h3v3"/>
                    </svg>
                </div>
                <div>
                    <h1>Ringkasan Operasional Bengkel</h1>
                    <p>Pantau ringkasan booking, data mekanik, dan aktivitas bengkel dalam satu tempat.</p>
                </div>
            </div>

            <div class="date-box">
                <div class="date-icon">
                    <svg width="21" height="21" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="4" width="18" height="17" rx="2"/>
                        <path d="M8 2v4M16 2v4M3 10h18"/>
                    </svg>
                </div>
                <div>
                    <div id="liveDate" class="date-text">Memuat tanggal...</div>
                    <div id="liveTime" class="time-text">--:--:-- WIB</div>
                </div>
            </div>
        </section>

        <section class="stats">
            <div class="stat-card stat-blue">
                <div class="stat-icon">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="4" width="18" height="17" rx="2"/><path d="M8 2v4M16 2v4M3 10h18"/>
                    </svg>
                </div>
                <div>
                    <div class="stat-title">Total Booking</div>
                    <div class="stat-number">{{ $totalBooking }}</div>
                    <div class="stat-description">Semua pesanan pelanggan</div>
                </div>
            </div>

            <div class="stat-card stat-orange">
                <div class="stat-icon">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/>
                    </svg>
                </div>
                <div>
                    <div class="stat-title">Booking Menunggu</div>
                    <div class="stat-number">{{ $bookingMenunggu }}</div>
                    <div class="stat-description">Booking yang belum ditangani</div>
                </div>
            </div>

            <div class="stat-card stat-green">
                <div class="stat-icon">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="9"/><path d="m8 12 2.5 2.5L16 9"/>
                    </svg>
                </div>
                <div>
                    <div class="stat-title">Servis Selesai</div>
                    <div class="stat-number">{{ $servisSelesai }}</div>
                    <div class="stat-description">Pesanan yang sudah selesai</div>
                </div>
            </div>
        </section>

        <section class="dashboard-grid">
            <section class="panel">
                <div class="panel-header">
                    <div class="panel-heading">
                        <div class="panel-heading-icon">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="4" width="18" height="17" rx="2"/>
                                <path d="M8 2v4M16 2v4M3 10h18"/>
                            </svg>
                        </div>
                        <div>
                            <div class="panel-title">Ringkasan Booking</div>
                            <div class="panel-subtitle">Informasi booking pelanggan untuk memantau operasional bengkel.</div>
                        </div>
                    </div>
                </div>

                <div class="summary-content">
                    <div class="summary-item">
                        <div class="summary-icon summary-blue">
                            <svg width="23" height="23" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="4" width="18" height="17" rx="2"/>
                                <path d="M8 2v4M16 2v4M3 10h18"/>
                            </svg>
                        </div>
                        <div>
                            <div class="summary-label">Booking Hari Ini</div>
                            <div class="summary-number">{{ $bookingHariIni }}</div>
                            <div class="summary-description">Booking dengan tanggal hari ini</div>
                        </div>
                    </div>

                    <div class="summary-item">
                        <div class="summary-icon summary-orange">
                            <svg width="23" height="23" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/>
                            </svg>
                        </div>
                        <div>
                            <div class="summary-label">Perlu Ditangani</div>
                            <div class="summary-number">{{ $bookingMenunggu }}</div>
                            <div class="summary-description">Booking yang masih menunggu</div>
                        </div>
                    </div>

                    <a href="{{ route('admin.pelanggan-pesanan') }}" class="summary-link">
                        Lihat Pengelolaan Pesanan <span>→</span>
                    </a>
                </div>
            </section>

            <section class="panel">
                <div class="panel-header">
                    <div class="panel-heading">
                        <div class="panel-heading-icon">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="9"/><path d="m8 12 3 3 5-6"/>
                            </svg>
                        </div>
                        <div>
                            <div class="panel-title">Ringkasan Mekanik</div>
                            <div class="panel-subtitle">Pantau jumlah mekanik berdasarkan statusnya.</div>
                        </div>
                    </div>
                </div>

                <div class="summary-content">
                    <div class="summary-item">
                        <div class="summary-icon summary-green">
                            <svg width="23" height="23" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="m5 12 4 4L19 6"/>
                            </svg>
                        </div>
                        <div>
                            <div class="summary-label">Mekanik Aktif</div>
                            <div class="summary-number">{{ $mekanikAktif }}</div>
                            <div class="summary-description">Status mekanik aktif</div>
                        </div>
                    </div>

                    <div class="summary-item">
                        <div class="summary-icon summary-red">
                            <svg width="23" height="23" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M6 6l12 12M18 6 6 18"/>
                            </svg>
                        </div>
                        <div>
                            <div class="summary-label">Mekanik Nonaktif</div>
                            <div class="summary-number">{{ $mekanikNonaktif }}</div>
                            <div class="summary-description">Status mekanik nonaktif</div>
                        </div>
                    </div>

                    <a href="{{ route('admin.mekanik.index') }}" class="summary-link">
                        Lihat Data Mekanik <span>→</span>
                    </a>
                </div>
            </section>

            <section class="panel activity-panel">
                <div class="panel-header">
                    <div class="panel-heading">
                        <div class="panel-heading-icon">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="4" y="3" width="16" height="18" rx="2"/>
                                <path d="M8 7h8M8 11h8M8 15h5"/>
                            </svg>
                        </div>
                        <div>
                            <div class="panel-title">Aktivitas Booking Terbaru</div>
                            <div class="panel-subtitle">Lima booking terbaru. Tidak ada aksi pengelolaan di bagian ini.</div>
                        </div>
                    </div>
                </div>

                <div class="table-wrapper">
                    <table class="booking-table">
                        <thead>
                            <tr>
                                <th>Pelanggan</th>
                                <th>Kendaraan</th>
                                <th>Tanggal Booking</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($aktivitasTerbaru as $item)
                                @php
                                    $status = strtolower($item->status ?? '');
                                @endphp
                                <tr>
                                    <td>
                                        <span class="customer-name">{{ $item->user->name ?? 'Pelanggan' }}</span>
                                        <span class="customer-detail">{{ $item->plat_nomor ?? '-' }}</span>
                                    </td>
                                    <td>{{ $item->nama_motor ?? '-' }}</td>
                                    <td>
                                        {{ $item->tanggal_booking
                                            ? \Carbon\Carbon::parse($item->tanggal_booking)->format('d M Y')
                                            : '-' }}
                                    </td>
                                    <td>
                                        @if(in_array($status, ['menunggu', 'pending']))
                                            <span class="status waiting">● Menunggu</span>
                                        @elseif($status === 'selesai')
                                            <span class="status done">● Selesai</span>
                                        @elseif($status === 'ditolak')
                                            <span class="status rejected">● Ditolak</span>
                                        @else
                                            <span class="status process">● {{ ucfirst($item->status ?? '-') }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4">
                                        <div class="empty-state">Belum ada aktivitas booking.</div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="table-footer">
                    <span>Menampilkan {{ $aktivitasTerbaru->count() }} aktivitas terbaru</span>
                    <a href="{{ route('admin.pelanggan-pesanan') }}">Kelola semua pesanan →</a>
                </div>
            </section>
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

    function updateClock() {
        const now = new Date();
        const dateElement = document.getElementById('liveDate');
        const timeElement = document.getElementById('liveTime');

        if (dateElement) {
            dateElement.textContent = now.toLocaleDateString('id-ID', {
                weekday: 'long',
                day: 'numeric',
                month: 'long',
                year: 'numeric'
            });
        }

        if (timeElement) {
            timeElement.textContent = now.toLocaleTimeString('id-ID', {
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit',
                hour12: false
            }) + ' WIB';
        }
    }

    updateClock();
    setInterval(updateClock, 1000);
</script>
</body>
</html>