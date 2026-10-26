<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Bengkel Royal Motor')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Cegah sidebar berkedip saat pindah halaman -->
    <script>
        (() => {
            try {
                const desktop = window.matchMedia('(min-width: 1001px)').matches;
                const desktopCollapsed =
                    sessionStorage.getItem('royalMotorSidebarDesktopCollapsed') === 'true';

                if (desktop && desktopCollapsed) {
                    document.documentElement.classList.add('sidebar-initial-hidden');
                }
            } catch (error) {
                // Jika sessionStorage tidak tersedia, pakai kondisi CSS normal.
            }
        })();
    </script>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            overflow-y: scroll;
        }

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

        body {
            font-family: Arial, Helvetica, sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        button {
            font: inherit;
            cursor: pointer;
        }

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
            transition: transform .3s ease;
        }

        .sidebar-brand {
            min-height: 72px;
            display: flex;
            align-items: center;
            padding: 0 29px;
            border-bottom: 1px solid #ffffff14;
        }

        .brand-title {
            font-size: 15px;
            font-weight: 800;
            letter-spacing: -.35px;
            line-height: 1.4;
        }

        .brand-subtitle {
            font-size: 10px;
            color: #aeb9cf;
            margin-top: 5px;
            letter-spacing: .1px;
        }

        .sidebar-menu {
            padding: 27px 12px;
            flex: 1;
        }

        .menu-label {
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 1.2px;
            color: #91a0bb;
            padding: 0 20px;
            margin-bottom: 15px;
        }

        .menu-link {
            min-height: 48px;
            padding: 0 17px;
            margin-bottom: 6px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            gap: 13px;
            color: #f1f4fa;
            font-size: 13px;
            transition: background .22s ease, color .22s ease, padding-left .22s ease;
            position: relative;
            overflow: hidden;
        }

        .menu-link svg {
            width: 21px;
            height: 21px;
            flex-shrink: 0;
            transition: transform .22s ease;
        }

        .menu-link::before {
            content: "";
            position: absolute;
            left: 0;
            top: 11px;
            bottom: 11px;
            width: 3px;
            background: #ffffff;
            border-radius: 0 4px 4px 0;
            transform: scaleY(0);
            transition: transform .22s ease;
        }

        .menu-link:hover {
            background: #ffffff10;
            color: #ffffff;
            padding-left: 21px;
        }

        .menu-link:hover svg {
            transform: translateX(1px);
        }

        .menu-link.active {
            background: linear-gradient(90deg, #3567d9, #355dbb);
            box-shadow: 0 5px 15px #305fd02b;
            color: white;
        }

        .menu-link.active::before {
            transform: scaleY(1);
        }

        .sidebar-footer {
            padding: 16px 18px 18px;
            border-top: 1px solid #ffffff12;
        }

        .sidebar-footer-card {
            padding: 12px 11px;
            border: 1px solid #ffffff10;
            background: #ffffff08;
            border-radius: 11px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .footer-status {
            width: 9px;
            height: 9px;
            background: #30cda0;
            border-radius: 50%;
            flex-shrink: 0;
            box-shadow: 0 0 0 4px #30cda018;
        }

        .footer-text strong {
            display: block;
            font-size: 10px;
            font-weight: 700;
        }

        .footer-text small {
            display: block;
            color: #aeb9cf;
            font-size: 9px;
            margin-top: 5px;
        }

        /* MAIN */
        .main {
            margin-left: 278px;
            min-height: 100vh;
            transition: margin-left .3s ease;
        }

        /* TOPBAR */
        .topbar {
            min-height: 72px;
            width: 100%;
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

        /* HAMBURGER */
        .mobile-menu,
        .desktop-menu {
            width: 40px;
            height: 40px;
            padding: 0;
            border: 1px solid transparent;
            border-radius: 9px;
            background: transparent;
            color: #243653;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            transition: background .2s ease, border-color .2s ease, color .2s ease;
        }

        .mobile-menu {
            display: none;
            background: #f3f6fa;
        }

        .mobile-menu:hover,
        .desktop-menu:hover {
            background: #eaf0fa;
            border-color: #dce5f1;
        }

        .mobile-menu:focus-visible,
        .desktop-menu:focus-visible {
            outline: 3px solid #3264d833;
            outline-offset: 2px;
        }

        .menu-icon {
            display: block;
            width: 20px;
            height: 16px;
            flex-shrink: 0;
        }

        .menu-icon line {
            stroke: currentColor;
            stroke-width: 2;
            stroke-linecap: round;
        }

        .topbar-spacer {
            flex: 1;
            min-width: 0;
        }

        /* KONTAK */
        .topbar-contact {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            min-height: 40px;
            padding: 0 12px;
            border: 1px solid #dce5f1;
            border-radius: 10px;
            background: #ffffff;
            color: #263b5b;
            font-size: 12px;
            font-weight: 700;
            white-space: nowrap;
            flex-shrink: 0;
            transition: background .2s ease, border-color .2s ease, color .2s ease;
        }

        .topbar-contact:hover {
            background: #f0f5ff;
            border-color: #c8d8f5;
            color: #3264d8;
        }

        .topbar-contact:focus-visible {
            outline: 3px solid #3264d833;
            outline-offset: 2px;
        }

        .topbar-contact svg {
            width: 18px;
            height: 18px;
            flex-shrink: 0;
        }

        /* JAM DIGITAL */
        .topbar-clock {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 7px 12px;
            background: #f4f7ff;
            border: 1px solid #e0e8fa;
            border-radius: 12px;
            flex-shrink: 0;
        }

        .clock-icon {
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #e8efff;
            color: #3264d8;
            border-radius: 9px;
            flex-shrink: 0;
        }

        .clock-icon svg {
            width: 19px;
            height: 19px;
        }

        .clock-info {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .clock-date {
            font-size: 10px;
            color: #7182a3;
            white-space: nowrap;
        }

        .clock-time {
            font-size: 16px;
            font-weight: 800;
            letter-spacing: .4px;
            color: #172541;
            font-variant-numeric: tabular-nums;
        }

        /* PROFIL */
        .profile-wrap {
            position: relative;
            flex-shrink: 0;
        }

        .profile-trigger {
            display: flex;
            align-items: center;
            gap: 10px;
            border: 0;
            background: transparent;
            padding: 6px 8px;
            border-radius: 10px;
            text-align: left;
            transition: background .2s ease;
        }

        .profile-trigger:hover,
        .profile-trigger[aria-expanded="true"] {
            background: #f5f7fb;
        }

        .avatar {
            width: 39px;
            height: 39px;
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

        .avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .profile-text strong {
            display: block;
            font-size: 12px;
            color: #182543;
            max-width: 130px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .profile-text small {
            display: block;
            margin-top: 4px;
            font-size: 10px;
            color: #7182a3;
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

        /* DROPDOWN PROFIL */
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
                transform: translateY(-5px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .dropdown-heading {
            padding: 10px 11px 12px;
            border-bottom: 1px solid #edf1f7;
            margin-bottom: 5px;
        }

        .dropdown-heading strong {
            display: block;
            font-size: 13px;
            overflow-wrap: anywhere;
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
            transition: background .18s ease;
        }

        .dropdown-link:hover {
            background: #f2f6fc;
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

        .dropdown-link.logout:hover {
            background: #fff0f2;
        }

        /* KONTEN */
        .content {
            padding: 20px 25px 28px;
            max-width: 1600px;
            margin: auto;
            min-width: 0;
        }

        .overlay {
            display: none;
        }

        .overlay.show {
            display: block;
            position: fixed;
            inset: 0;
            background: #0a142873;
            z-index: 900;
        }

        /* DESKTOP */
        @media (min-width: 1001px) {
            .sidebar.collapsed {
                transform: translateX(-100%);
            }

            .main.sidebar-collapsed {
                margin-left: 0;
            }

            /* Kondisi awal sebelum JavaScript sidebar jalan (anti kedip) */
            html.sidebar-initial-hidden .sidebar {
                transform: translateX(-100%);
            }

            html.sidebar-initial-hidden .main {
                margin-left: 0;
            }
        }

        /* TABLET */
        @media (max-width: 1000px) {
            .sidebar {
                transform: translateX(-100%);
                box-shadow: none;
            }

            .sidebar.open {
                transform: translateX(0);
                box-shadow: 12px 0 35px #101b302b;
            }

            .main {
                margin-left: 0;
            }

            .mobile-menu {
                display: flex;
            }

            .desktop-menu {
                display: none;
            }
        }

        /* HP */
        @media (max-width: 700px) {
            .topbar {
                min-height: 64px;
                height: 64px;
                padding: 0 12px;
                gap: 7px;
            }

            .content {
                padding: 14px;
            }

            .mobile-menu {
                width: 36px;
                height: 36px;
            }

            .menu-icon {
                width: 19px;
                height: 15px;
            }

            .topbar-contact {
                width: 36px;
                min-height: 36px;
                padding: 0;
                gap: 0;
            }

            .topbar-contact-label {
                display: none;
            }

            .topbar-clock {
                padding: 5px 8px;
                gap: 7px;
            }

            .clock-icon {
                width: 30px;
                height: 30px;
            }

            .clock-icon svg {
                width: 17px;
                height: 17px;
            }

            .clock-date {
                font-size: 9px;
            }

            .clock-time {
                font-size: 13px;
            }

            .profile-trigger {
                gap: 6px;
                padding: 4px;
            }

            .avatar {
                width: 36px;
                height: 36px;
            }

            .profile-text strong {
                font-size: 11px;
                max-width: 85px;
            }

            .profile-text small {
                font-size: 10px;
            }

            .chevron {
                width: 13px;
                height: 13px;
            }

            .profile-dropdown {
                right: 0;
                width: 220px;
            }
        }

        @media (max-width: 390px) {
            .topbar {
                padding: 0 8px;
                gap: 5px;
            }

            .topbar-clock {
                padding: 5px 6px;
                gap: 6px;
            }

            .clock-icon {
                width: 27px;
                height: 27px;
            }

            .clock-date {
                font-size: 8px;
            }

            .clock-time {
                font-size: 12px;
            }

            .profile-text,
            .chevron {
                display: none;
            }

            .avatar {
                width: 34px;
                height: 34px;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            *,
            *::before,
            *::after {
                animation-duration: .01ms !important;
                animation-iteration-count: 1 !important;
                scroll-behavior: auto !important;
                transition-duration: .01ms !important;
            }
        }
    </style>

    @stack('styles')
</head>

<body>

@php
    $namaPelanggan = auth()->user()->name ?? 'Pelanggan';
@endphp

<div id="overlay" class="overlay" onclick="tutupSidebarMobile()"></div>

<!-- SIDEBAR -->
<aside id="sidebar" class="sidebar">

    <div class="sidebar-brand">
        <div>
            <div class="brand-title">Bengkel Royal Motor</div>
            <div class="brand-subtitle">Servis Motor, Solusi Perjalananmu</div>
        </div>
    </div>

    <nav class="sidebar-menu">
        <div class="menu-label">MENU PELANGGAN</div>

        <a href="{{ route('dashboard') }}"
           class="menu-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
           onclick="tutupSidebarMobile()">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M3 11 12 4l9 7"/>
                <path d="M5 10v10h14V10"/>
                <path d="M9 20v-6h6v6"/>
            </svg>
            <span>Dashboard</span>
        </a>

        <a href="{{ route('booking.create') }}"
           class="menu-link {{ request()->routeIs('booking.create') ? 'active' : '' }}"
           onclick="tutupSidebarMobile()">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect x="3" y="4" width="18" height="17" rx="2"/>
                <path d="M8 2v4M16 2v4M3 10h18"/>
                <path d="M12 13v5M9.5 15.5h5"/>
            </svg>
            <span>Booking Servis</span>
        </a>

        <a href="{{ route('booking.index') }}"
           class="menu-link {{ request()->routeIs('booking.index') ? 'active' : '' }}"
           onclick="tutupSidebarMobile()">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect x="4" y="3" width="16" height="18" rx="2"/>
                <path d="M8 8h8M8 12h8M8 16h5"/>
            </svg>
            <span>Riwayat Booking</span>
        </a>

        <a href="{{ route('layanan.index') }}"
           class="menu-link {{ request()->routeIs('layanan.*') ? 'active' : '' }}"
           onclick="tutupSidebarMobile()">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <path d="M4 5h16v14H4z"/>
                <path d="M8 9h8M8 13h5"/>
                <path d="M8 2v3M16 2v3"/>
            </svg>
            <span>Layanan &amp; Harga</span>
        </a>
    </nav>

    <div class="sidebar-footer">
        <div class="sidebar-footer-card">
            <span class="footer-status"></span>
            <div class="footer-text">
                <strong>Bengkel Royal Motor</strong>
                <small>Layanan booking servis online</small>
            </div>
        </div>
    </div>
</aside>

<!-- MAIN -->
<div class="main">

    <header class="topbar">

        <button type="button"
                class="mobile-menu"
                onclick="toggleSidebar()"
                aria-label="Buka atau tutup menu"
                aria-controls="sidebar">
            <svg class="menu-icon" viewBox="0 0 20 16" fill="none" aria-hidden="true">
                <line x1="1" y1="2" x2="19" y2="2"/>
                <line x1="1" y1="8" x2="19" y2="8"/>
                <line x1="1" y1="14" x2="19" y2="14"/>
            </svg>
        </button>

        <button type="button"
                class="desktop-menu"
                onclick="toggleSidebar()"
                aria-label="Tampilkan atau sembunyikan menu"
                aria-controls="sidebar">
            <svg class="menu-icon" viewBox="0 0 20 16" fill="none" aria-hidden="true">
                <line x1="1" y1="2" x2="19" y2="2"/>
                <line x1="1" y1="8" x2="19" y2="8"/>
                <line x1="1" y1="14" x2="19" y2="14"/>
            </svg>
        </button>

        <!-- KONTAK: tidak memaksa sidebar terbuka saat pindah halaman -->
        <a href="{{ route('kontak') }}"
           class="topbar-contact"
           aria-label="Buka halaman kontak"
           title="Kontak">

            <svg viewBox="0 0 24 24"
                 fill="none"
                 stroke="currentColor"
                 stroke-width="1.8"
                 stroke-linecap="round"
                 stroke-linejoin="round"
                 aria-hidden="true">
                <path d="M22 16.9v3a2 2 0 0 1-2.2 2
                        19.8 19.8 0 0 1-8.6-3.1
                        19.5 19.5 0 0 1-6-6
                        A19.8 19.8 0 0 1 2.1 4.2
                        2 2 0 0 1 4.1 2h3
                        a2 2 0 0 1 2 1.7
                        c.1 1 .4 1.9.7 2.8
                        a2 2 0 0 1-.5 2.1L8 9.9
                        a16 16 0 0 0 6 6l1.3-1.3
                        a2 2 0 0 1 2.1-.4
                        c.9.3 1.8.6 2.8.7
                        a2 2 0 0 1 1.7 2z"/>
            </svg>

            <span class="topbar-contact-label">Kontak</span>
        </a>

        <div class="topbar-spacer"></div>

        <!-- JAM DAN TANGGAL -->
        <div class="topbar-clock">
            <div class="clock-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <circle cx="12" cy="12" r="9"/>
                    <path d="M12 7v5l3 2"/>
                </svg>
            </div>

            <div class="clock-info">
                <div class="clock-date" id="topbarDate">Memuat tanggal...</div>
                <div class="clock-time" id="topbarTime">00:00:00</div>
            </div>
        </div>

        <!-- PROFIL -->
        <div class="profile-wrap" id="profileWrap">
            <button type="button"
                    class="profile-trigger"
                    id="profileTrigger"
                    aria-expanded="false"
                    aria-controls="profileDropdown"
                    onclick="toggleProfileDropdown()">

                <div class="avatar">
                    @if(auth()->user()->profile_photo_url)
                        <img src="{{ auth()->user()->profile_photo_url }}" alt="Foto profil">
                    @else
                        {{ strtoupper(substr($namaPelanggan, 0, 1)) }}
                    @endif
                </div>

                <div class="profile-text">
                    <strong>{{ $namaPelanggan }}</strong>
                    <small>Pelanggan</small>
                </div>

                <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="m6 9 6 6 6-6"/>
                </svg>
            </button>

            <div class="profile-dropdown" id="profileDropdown">
                <div class="dropdown-heading">
                    <strong>{{ $namaPelanggan }}</strong>
                    <small>akun pelanggan</small>
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
                            <path d="M10 17l5-5-5-5M15 12H3"/>
                            <path d="M21 19V5a2 2 0 0 0-2-2h-6"/>
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
    /* JAM DIGITAL */
    function updateTopbarClock() {
        const dateElement = document.getElementById('topbarDate');
        const timeElement = document.getElementById('topbarTime');

        if (!dateElement || !timeElement) return;

        const now = new Date();

        dateElement.textContent = new Intl.DateTimeFormat('id-ID', {
            weekday: 'short',
            day: '2-digit',
            month: 'short',
            year: 'numeric',
            timeZone: 'Asia/Jakarta'
        }).format(now);

        timeElement.textContent = new Intl.DateTimeFormat('id-ID', {
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit',
            hour12: false,
            timeZone: 'Asia/Jakarta'
        }).format(now);
    }

    updateTopbarClock();
    setInterval(updateTopbarClock, 1000);

    /* SIDEBAR: SIMPAN KONDISI SAAT PINDAH HALAMAN */
    const SIDEBAR_DESKTOP_KEY = 'royalMotorSidebarDesktopCollapsed';
    const SIDEBAR_MOBILE_KEY = 'royalMotorSidebarMobileOpen';

    function terapkanKondisiSidebar() {
        const sidebar = document.getElementById('sidebar');
        const main = document.querySelector('.main');
        const overlay = document.getElementById('overlay');

        if (!sidebar || !main || !overlay) return;

        if (window.innerWidth <= 1000) {
            const isOpen = sessionStorage.getItem(SIDEBAR_MOBILE_KEY) === 'true';

            sidebar.classList.remove('collapsed');
            main.classList.remove('sidebar-collapsed');
            sidebar.classList.toggle('open', isOpen);
            overlay.classList.toggle('show', isOpen);
            document.body.style.overflow = isOpen ? 'hidden' : '';
        } else {
            const isCollapsed = sessionStorage.getItem(SIDEBAR_DESKTOP_KEY) === 'true';

            sidebar.classList.remove('open');
            sidebar.classList.toggle('collapsed', isCollapsed);
            main.classList.toggle('sidebar-collapsed', isCollapsed);
            overlay.classList.remove('show');
            document.body.style.overflow = '';
        }
    }

    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const main = document.querySelector('.main');
        const overlay = document.getElementById('overlay');

        if (window.innerWidth <= 1000) {
            const isOpen = !sidebar.classList.contains('open');

            sidebar.classList.toggle('open', isOpen);
            overlay.classList.toggle('show', isOpen);
            document.body.style.overflow = isOpen ? 'hidden' : '';
            sessionStorage.setItem(SIDEBAR_MOBILE_KEY, isOpen ? 'true' : 'false');
        } else {
            const isCollapsed = !sidebar.classList.contains('collapsed');

            sidebar.classList.toggle('collapsed', isCollapsed);
            main.classList.toggle('sidebar-collapsed', isCollapsed);
            sessionStorage.setItem(SIDEBAR_DESKTOP_KEY, isCollapsed ? 'true' : 'false');
        }
    }

    /* Tutup sidebar hanya di HP/tablet. Di desktop tidak melakukan apa-apa,
       jadi klik menu tidak lagi menyembunyikan sidebar. */
    function tutupSidebarMobile() {
        if (window.innerWidth > 1000) return;

        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');

        sidebar.classList.remove('open');
        overlay.classList.remove('show');
        document.body.style.overflow = '';
        sessionStorage.setItem(SIDEBAR_MOBILE_KEY, 'false');
    }

    /* TERAPKAN KONDISI SIDEBAR SAAT HALAMAN DIBUKA */
    terapkanKondisiSidebar();
    document.documentElement.classList.remove('sidebar-initial-hidden');

    /* SESUAIKAN SIDEBAR SAAT UKURAN LAYAR BERUBAH */
    window.addEventListener('resize', function () {
        terapkanKondisiSidebar();

        if (window.innerWidth > 1000) {
            document.body.style.overflow = '';
        }
    });

    /* DROPDOWN PROFIL */
    function toggleProfileDropdown() {
        const dropdown = document.getElementById('profileDropdown');
        const trigger = document.getElementById('profileTrigger');

        const isOpen = dropdown.classList.toggle('show');

        trigger.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
    }

    function closeProfileDropdown() {
        const dropdown = document.getElementById('profileDropdown');
        const trigger = document.getElementById('profileTrigger');

        if (dropdown) {
            dropdown.classList.remove('show');
        }

        if (trigger) {
            trigger.setAttribute('aria-expanded', 'false');
        }
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
</script>

@stack('scripts')

</body>
</html>