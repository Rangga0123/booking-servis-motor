<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pelanggan & Pesanan - Bengkel Royal Motor</title>

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

        .main.sidebar-collapsed { margin-left: 0; }

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
            from { opacity: 0; transform: translateY(-7px) scale(.98); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        .dropdown-heading {
            padding: 10px 11px 12px;
            border-bottom: 1px solid #edf1f7;
            margin-bottom: 5px;
        }

        .dropdown-heading strong { display: block; font-size: 13px; }

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
        .content { padding: 20px 25px 28px; max-width: 1600px; margin: auto; }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(12px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .welcome, .stat-card, .panel { animation: fadeUp .45s ease both; }

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

        .dashboard-grid {
            display: grid;
            grid-template-columns: minmax(0, 1fr) 390px;
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
        .filter-row { margin-top: 14px; display: flex; justify-content: flex-end; }

        .filter-select {
            width: 165px;
            height: 38px;
            border: 1px solid #d9e3ef;
            border-radius: 9px;
            background: #fbfdff;
            padding: 0 10px;
            outline: none;
            color: #435574;
            font-size: 11px;
        }

        .filter-select:focus, .form-control:focus {
            border-color: #87a9e7;
            box-shadow: 0 0 0 3px #3264d817;
        }

        .table-wrapper { overflow-x: auto; }
        .booking-table { width: 100%; border-collapse: collapse; min-width: 690px; }

        .booking-table th {
            height: 43px;
            padding: 0 12px;
            background: #f5f8fc;
            border-right: 1px solid #e7edf5;
            border-bottom: 1px solid #dfe7f1;
            font-size: 10px;
            text-align: left;
            white-space: nowrap;
        }

        .booking-table td {
            padding: 14px 12px;
            border-right: 1px solid #e7edf5;
            border-bottom: 1px solid #e3eaf3;
            vertical-align: middle;
            font-size: 11px;
            color: #41577b;
        }

        .booking-table tr:hover td { background: #fbfdff; }
        .booking-table th:last-child, .booking-table td:last-child { border-right: 0; }
        .customer-name { font-size: 12px; color: #17243f; font-weight: 800; }
        .customer-detail, .vehicle-plate { display: block; margin-top: 5px; color: #43628f; font-size: 10px; }
        .complaint { max-width: 160px; line-height: 1.5; }
        .booking-date { color: #526d9d; line-height: 1.5; }

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

        .detail-btn {
            height: 30px;
            min-width: 76px;
            border-radius: 7px;
            border: 0;
            background: linear-gradient(135deg, #2b395b, #202c48);
            color: white;
            font-size: 10px;
            font-weight: 700;
            transition: transform .2s ease, box-shadow .2s ease;
        }

        .detail-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 12px #202c4833;
        }

        .table-footer {
            padding: 13px 17px;
            color: #7184a8;
            font-size: 10px;
            display: flex;
            justify-content: space-between;
            gap: 10px;
        }

        .schedule-title-row { display: flex; align-items: center; justify-content: space-between; gap: 8px; }
        .schedule-heading { display: flex; align-items: center; gap: 9px; }
        .schedule-title { font-size: 15px; font-weight: 800; }
        .today-badge { border-radius: 18px; background: #eff5fd; color: #506a96; padding: 7px 9px; font-size: 9px; white-space: nowrap; }
        .schedule-list { padding: 10px; max-height: 690px; overflow-y: auto; }

        .schedule-card {
            border: 1px solid #dde5f0;
            border-radius: 12px;
            padding: 11px;
            margin-bottom: 10px;
            background: white;
            box-shadow: 0 3px 8px #243d6508;
            transition: transform .22s ease, box-shadow .22s ease;
        }

        .schedule-card:hover { transform: translateY(-2px); box-shadow: 0 8px 18px #243d6512; }
        .schedule-card-top { display: flex; justify-content: space-between; align-items: center; gap: 6px; margin-bottom: 10px; }
        .order-title { font-size: 10px; font-weight: 800; color: #263b63; }
        .form-two { display: grid; grid-template-columns: 1fr 1fr; gap: 9px; }
        .field { margin-bottom: 9px; }
        .field label { display: block; font-size: 10px; color: #485e85; margin-bottom: 5px; font-weight: 600; }

        .form-control {
            width: 100%;
            height: 35px;
            border: 1px solid #d6e1ef;
            background: #f9fbfe;
            border-radius: 7px;
            padding: 0 8px;
            color: #39517c;
            font-size: 11px;
            outline: none;
        }

        .action-row { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; margin-top: 9px; }

        .btn {
            min-height: 34px;
            border: 0;
            border-radius: 7px;
            color: white;
            font-size: 10px;
            font-weight: 700;
            padding: 6px 8px;
            transition: transform .2s ease, filter .2s ease;
        }

        .btn:hover { filter: brightness(.97); transform: translateY(-1px); }
        .btn-green { background: linear-gradient(90deg, #13996e, #20b287); }
        .btn-red { background: linear-gradient(90deg, #f13c59, #f22e50); }
        .btn-blue { background: linear-gradient(90deg, #1589ed, #4f6df5); }
        .btn-dark { background: linear-gradient(90deg, #31405e, #25334f); }
        .full { grid-column: 1 / -1; }
        .empty-state { padding: 35px 15px; text-align: center; color: #8393ae; font-size: 11px; }

        .modal {
            display: none;
            position: fixed;
            inset: 0;
            background: #0c172b8f;
            z-index: 2000;
            align-items: center;
            justify-content: center;
            padding: 18px;
        }

        .modal.show { display: flex; animation: fadeIn .2s ease; }

        .modal-box {
            width: 100%;
            max-width: 520px;
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 25px 70px #0003;
            max-height: 90vh;
            overflow-y: auto;
            animation: fadeUp .25s ease;
        }

        .modal-header {
            padding: 17px 20px;
            border-bottom: 1px solid #e6ebf2;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .modal-header h3 { font-size: 17px; }
        .close-modal { width: 34px; height: 34px; border-radius: 8px; border: 0; background: #f3f6fa; color: #394c6d; }
        .modal-content { padding: 20px; }
        .detail-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
        .detail-item { background: #f8fafd; padding: 12px; border-radius: 9px; overflow-wrap: anywhere; }
        .detail-item small { color: #7c8da9; display: block; margin-bottom: 6px; }
        .detail-item strong { font-size: 12px; color: #263956; }

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
            .dashboard-grid { grid-template-columns: minmax(0, 1fr); }
            .schedule-list { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); max-height: none; gap: 10px; }
            .schedule-card { margin: 0; }
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
            .date-box { width: 100%; min-width: 0; }
            .dashboard-grid { grid-template-columns: minmax(0, 1fr); }
            .schedule-list { display: block; }
            .schedule-card { margin-bottom: 10px; }
            .filter-row { justify-content: stretch; }
            .filter-select { width: 100%; }
            .detail-grid { grid-template-columns: 1fr; }
            .panel-header { padding: 13px; }
            .panel-title { font-size: 14px; }
            .panel-subtitle { font-size: 10px; }
        }

        @media (max-width: 380px) {
            .sidebar { width: 265px; }
            .welcome h1 { font-size: 18px; }
            .welcome-left { align-items: flex-start; }
            .schedule-title { font-size: 13px; }
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

    $jadwalAktif = $bookings->filter(function ($booking) {
        return strtolower($booking->status ?? '') !== 'ditolak';
    });
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

        <a href="{{ route('admin.pelanggan-pesanan') }}" class="menu-link active" onclick="tutupSidebarMobile()">
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
                <div class="welcome-hand">
                    <svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <circle cx="12" cy="8" r="4"/>
                        <path d="M4 21c0-4 3.6-7 8-7s8 3 8 7"/>
                    </svg>
                </div>
                <div>
                    <h1>Pelanggan &amp; Pesanan</h1>
                    <p>Kelola pelanggan, booking masuk, jadwal servis, dan status pesanan dalam satu tempat.</p>
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

        <section class="dashboard-grid">
            <section id="pesanan" class="panel">
                <div class="panel-header">
                    <div class="panel-heading">
                        <div class="panel-heading-icon">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="4" y="3" width="16" height="18" rx="2"/>
                                <path d="M8 7h8M8 11h8M8 15h5"/>
                            </svg>
                        </div>
                        <div>
                            <div class="panel-title">Daftar Pesanan Servis Masuk</div>
                            <div class="panel-subtitle">Lihat detail pesanan, tanggal booking, dan status pelanggan.</div>
                        </div>
                    </div>

                    <div class="filter-row">
                        <select id="statusFilter" class="filter-select" aria-label="Filter status booking">
                            <option value="">Semua Status</option>
                            <option value="menunggu">Menunggu</option>
                            <option value="disetujui">Disetujui</option>
                            <option value="selesai">Selesai</option>
                            <option value="ditolak">Ditolak</option>
                        </select>
                    </div>
                </div>

                <div class="table-wrapper">
                    <table class="booking-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Pelanggan</th>
                                <th>Kendaraan</th>
                                <th>Keluhan</th>
                                <th>Tanggal Booking</th>
                                <th>Status</th>
                                <th style="text-align:center">Aksi Admin</th>
                            </tr>
                        </thead>

                        <tbody id="bookingRows">
                            @forelse($bookings as $index => $item)
                                @php
                                    $status = strtolower($item->status ?? '');
                                    $jamBooking = $item->jam_booking
                                        ? str_replace(',', ':', trim($item->jam_booking))
                                        : '';
                                    $tanggalBooking = $item->tanggal_booking
                                        ? \Carbon\Carbon::parse($item->tanggal_booking)->format('d M Y')
                                        : '-';
                                @endphp

                                <tr class="booking-row" data-status="{{ $status }}">
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <span class="customer-name">{{ $item->user->name ?? 'Pelanggan' }}</span>
                                        <span class="customer-detail">{{ $item->user->email ?? 'Email tidak tersedia' }}</span>
                                        <span class="vehicle-plate">{{ $item->plat_nomor ?? '-' }}</span>
                                    </td>
                                    <td>{{ $item->nama_motor ?? '-' }}</td>
                                    <td><div class="complaint">{{ $item->keluhan ?? '-' }}</div></td>
                                    <td>
                                        <div class="booking-date">
                                            {{ $tanggalBooking }}
                                            @if($jamBooking)
                                                <br>{{ $jamBooking }}
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        @if(in_array($status, ['menunggu', 'pending']))
                                            <span class="status waiting">● Menunggu</span>
                                        @elseif($status === 'disetujui')
                                            <span class="status process">● Disetujui</span>
                                        @elseif($status === 'selesai')
                                            <span class="status done">● Selesai</span>
                                        @elseif($status === 'ditolak')
                                            <span class="status rejected">● Ditolak</span>
                                        @else
                                            <span class="status process">{{ ucfirst($item->status ?? '-') }}</span>
                                        @endif
                                    </td>
                                    <td style="text-align:center">
                                        <button
                                            type="button"
                                            class="detail-btn"
                                            onclick="openDetail(this)"
                                            data-customer="{{ $item->user->name ?? 'Pelanggan' }}"
                                            data-email="{{ $item->user->email ?? '-' }}"
                                            data-motor="{{ $item->nama_motor ?? '-' }}"
                                            data-plate="{{ $item->plat_nomor ?? '-' }}"
                                            data-service="{{ $item->jenis_servis ?? '-' }}"
                                            data-complaint="{{ $item->keluhan ?? '-' }}"
                                            data-date="{{ $tanggalBooking }}"
                                            data-time="{{ $jamBooking }}"
                                            data-status="{{ $item->status ?? '-' }}"
                                            data-mechanic="{{ $item->mechanic->nama_mekanik ?? 'Belum dipilih' }}"
                                        >◉ Detail</button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" style="padding:40px;text-align:center;color:#8190aa">
                                        Belum ada pesanan servis.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="table-footer">
                    <span>Menampilkan {{ $bookings->count() }} data</span>
                    <span>Total {{ $totalBooking }} pesanan</span>
                </div>
            </section>

            <section id="jadwal-servis" class="panel">
                <div class="panel-header">
                    <div class="schedule-title-row">
                        <div class="schedule-heading">
                            <svg width="23" height="23" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="4" width="18" height="17" rx="2"/>
                                <path d="M8 2v4M16 2v4M3 10h18"/>
                            </svg>
                            <div class="schedule-title">Pengaturan Jadwal Servis</div>
                        </div>
                        <span id="todayBadge" class="today-badge">Hari ini</span>
                    </div>
                </div>

                <div class="schedule-list">
                    @forelse($jadwalAktif as $index => $item)
                        @php
                            $status = strtolower($item->status ?? '');
                            $jamBooking = $item->jam_booking
                                ? str_replace(',', ':', trim($item->jam_booking))
                                : '';
                        @endphp

                        <div class="schedule-card">
                            <div class="schedule-card-top">
                                <div class="order-title">
                                    Pesanan #{{ $item->id }}
                                    <br>
                                    <span style="font-weight:400;margin-top:4px;display:inline-block">
                                        {{ $item->user->name ?? 'Pelanggan' }}
                                    </span>
                                </div>

                                @if(in_array($status, ['menunggu', 'pending']))
                                    <span class="status waiting">● Menunggu</span>
                                @elseif($status === 'disetujui')
                                    <span class="status process">● Disetujui</span>
                                @elseif($status === 'selesai')
                                    <span class="status done">● Selesai</span>
                                @endif
                            </div>

                            @if(in_array($status, ['menunggu', 'pending', 'disetujui']))
                                <form action="{{ route('admin.booking.update', $item->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <div class="form-two">
                                        <div class="field">
                                            <label>Tanggal Servis</label>
                                            <input
                                                class="form-control"
                                                type="date"
                                                name="tanggal_booking"
                                                value="{{ $item->tanggal_booking ? \Carbon\Carbon::parse($item->tanggal_booking)->format('Y-m-d') : '' }}"
                                                required
                                            >
                                        </div>

                                        <div class="field">
                                            <label>Jam Servis</label>
                                            <input
                                                class="form-control jam-input"
                                                type="text"
                                                name="jam_booking"
                                                value="{{ $jamBooking }}"
                                                placeholder="09:00"
                                                maxlength="5"
                                                inputmode="numeric"
                                                required
                                            >
                                        </div>
                                    </div>

                                    <div class="field">
                                        <label>Mekanik</label>
                                        <select class="form-control" name="mechanic_id" required>
                                            <option value="">Pilih Mekanik</option>
                                            @foreach($mechanics as $mechanic)
                                                <option
                                                    value="{{ $mechanic->id }}"
                                                    {{ $item->mechanic_id == $mechanic->id ? 'selected' : '' }}
                                                >
                                                    {{ $mechanic->nama_mekanik }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    @if(in_array($status, ['menunggu', 'pending']))
                                        <div class="action-row">
                                            <button class="btn btn-green" type="submit" name="status" value="Disetujui">
                                                ✓ Setujui
                                            </button>
                                            <button class="btn btn-red" type="submit" name="status" value="Ditolak">
                                                ✕ Tolak
                                            </button>
                                        </div>
                                    @elseif($status === 'disetujui')
                                        <button class="btn btn-blue full" style="width:100%" type="submit" name="status" value="Disetujui">
                                            Ubah Jadwal
                                        </button>
                                    @endif
                                </form>

                                @if($status === 'disetujui')
                                    <form action="{{ route('admin.booking.update', $item->id) }}" method="POST" style="margin-top:8px">
                                        @csrf
                                        @method('PUT')
                                        <button class="btn btn-dark" style="width:100%" type="submit" name="status" value="Selesai">
                                            ✓ Tandai Selesai
                                        </button>
                                    </form>
                                @endif
                            @elseif($status === 'selesai')
                                <button type="button" class="btn btn-dark" style="width:100%">
                                    ✓ Servis Selesai
                                </button>
                            @endif
                        </div>
                    @empty
                        <div class="empty-state">Belum ada jadwal servis.</div>
                    @endforelse
                </div>
            </section>
        </section>
    </main>
</div>

<div id="detailModal" class="modal" onclick="closeModalOutside(event)">
    <div class="modal-box">
        <div class="modal-header">
            <h3>Detail Pesanan Servis</h3>
            <button type="button" class="close-modal" onclick="closeDetail()">✕</button>
        </div>

        <div class="modal-content">
            <div class="detail-grid">
                <div class="detail-item"><small>Pelanggan</small><strong id="detailCustomer">-</strong></div>
                <div class="detail-item"><small>Email</small><strong id="detailEmail">-</strong></div>
                <div class="detail-item"><small>Kendaraan</small><strong id="detailMotor">-</strong></div>
                <div class="detail-item"><small>Plat Nomor</small><strong id="detailPlate">-</strong></div>
                <div class="detail-item"><small>Jenis Servis</small><strong id="detailService">-</strong></div>
                <div class="detail-item"><small>Tanggal</small><strong id="detailDate">-</strong></div>
                <div class="detail-item"><small>Jam</small><strong id="detailTime">-</strong></div>
                <div class="detail-item"><small>Mekanik</small><strong id="detailMechanic">-</strong></div>
                <div class="detail-item"><small>Status</small><strong id="detailStatus">-</strong></div>
                <div class="detail-item"><small>Keluhan</small><strong id="detailComplaint">-</strong></div>
            </div>
        </div>
    </div>
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
            closeDetail();
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
        const badgeElement = document.getElementById('todayBadge');

        if (dateElement) {
            dateElement.textContent = now.toLocaleDateString('id-ID', {
                weekday: 'long',
                day: 'numeric',
                month: 'long',
                year: 'numeric',
                timeZone: 'Asia/Jakarta'
            });
        }

        if (timeElement) {
            timeElement.textContent = now.toLocaleTimeString('id-ID', {
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit',
                hour12: false,
                timeZone: 'Asia/Jakarta'
            }) + ' WIB';
        }

        if (badgeElement) {
            badgeElement.textContent = now.toLocaleDateString('id-ID', {
                day: 'numeric',
                month: 'short',
                year: 'numeric',
                timeZone: 'Asia/Jakarta'
            });
        }
    }

    updateClock();
    setInterval(updateClock, 1000);

    document.querySelectorAll('.jam-input').forEach(function (input) {
        input.addEventListener('input', function () {
            let value = this.value.replace(/[^0-9]/g, '').substring(0, 4);

            if (value.length >= 3) {
                value = value.substring(0, 2) + ':' + value.substring(2);
            }

            this.value = value;
        });

        input.addEventListener('blur', function () {
            if (!/^\d{2}:\d{2}$/.test(this.value)) return;

            const parts = this.value.split(':');

            if (Number(parts[0]) > 23 || Number(parts[1]) > 59) {
                alert('Jam tidak valid. Gunakan format 24 jam, contoh 09:00 atau 13:45.');
                this.focus();
            }
        });
    });

    const statusFilter = document.getElementById('statusFilter');

    if (statusFilter) {
        statusFilter.addEventListener('change', function () {
            const selected = this.value.toLowerCase();

            document.querySelectorAll('.booking-row').forEach(function (row) {
                const status = (row.dataset.status || '').toLowerCase();
                const cocok = !selected ||
                    status === selected ||
                    (selected === 'menunggu' && status === 'pending');

                row.style.display = cocok ? '' : 'none';
            });
        });
    }

    function openDetail(button) {
        const data = button.dataset;

        document.getElementById('detailCustomer').textContent = data.customer || '-';
        document.getElementById('detailEmail').textContent = data.email || '-';
        document.getElementById('detailMotor').textContent = data.motor || '-';
        document.getElementById('detailPlate').textContent = data.plate || '-';
        document.getElementById('detailService').textContent = data.service || '-';
        document.getElementById('detailComplaint').textContent = data.complaint || '-';
        document.getElementById('detailDate').textContent = data.date || '-';
        document.getElementById('detailTime').textContent = data.time ? data.time + ' WIB' : '-';
        document.getElementById('detailStatus').textContent = data.status || '-';
        document.getElementById('detailMechanic').textContent = data.mechanic || '-';

        document.getElementById('detailModal').classList.add('show');
        document.body.style.overflow = 'hidden';
    }

    function closeDetail() {
        const modal = document.getElementById('detailModal');

        if (modal) {
            modal.classList.remove('show');
        }

        const sidebar = document.getElementById('sidebar');
        const sidebarOpen = window.innerWidth <= 1000 &&
            sidebar && sidebar.classList.contains('open');

        document.body.style.overflow = sidebarOpen ? 'hidden' : '';
    }

    function closeModalOutside(event) {
        if (event.target.id === 'detailModal') {
            closeDetail();
        }
    }
</script>
</body>
</html>