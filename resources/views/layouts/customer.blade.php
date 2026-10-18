<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Bengkel Royal Motor')</title>

    {{-- Dimuat lebih dulu supaya kelas Tailwind di halaman form tetap berfungsi --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        *{margin:0;padding:0;box-sizing:border-box}

        html {
            overflow-y: scroll;
        }

        :root{
            --sidebar:#14213d;--blue:#3264d8;--border:#dce5f1;
            --text:#14213d;--muted:#7182a3;--bg:#f4f7fb;
            --green:#19a875;--red:#f23d5e;--orange:#f7a11a
        }
        body{font-family:Arial,Helvetica,sans-serif;background:var(--bg);color:var(--text);min-height:100vh}
        a{color:inherit;text-decoration:none}
        button{font:inherit;cursor:pointer}
        .sidebar{
            position:fixed;inset:0 auto 0 0;width:278px;
            background:linear-gradient(180deg,#172541,#121c34);
            color:white;z-index:1000;display:flex;flex-direction:column;
            transition:transform .3s ease
        }
        .sidebar-brand{min-height:72px;display:flex;align-items:center;padding:0 29px;border-bottom:1px solid #ffffff14}
        .brand-title{font-size:16px;font-weight:800}
        .brand-subtitle{font-size:10px;color:#aeb9cf;margin-top:5px}
        .sidebar-menu{padding:27px 12px;flex:1}
        .menu-label{font-size:10px;font-weight:700;letter-spacing:1.2px;color:#91a0bb;padding:0 20px;margin-bottom:12px}
        .menu-link{
            min-height:50px;padding:0 20px;margin-bottom:5px;border-radius:11px;
            display:flex;align-items:center;gap:15px;color:#f1f4fa;font-size:14px;
            transition:background .22s ease,transform .22s ease
        }
        .menu-link svg{width:22px;height:22px;flex-shrink:0}
        .menu-link:hover {
                background: #ffffff14;
                transform: none;
            }
        .menu-link.active{background:linear-gradient(90deg,#3567d9,#355dbb);box-shadow:0 7px 22px #305fd059}
        .main{
                margin-left:278px;
                min-height:100vh;
                transition:none;
            }
        .topbar{
            height:72px;
            width:100%;
            background:#fffffff5;
            border-bottom:1px solid #e7edf5;
            display:flex;
            align-items:center;
            padding:0 25px;
            position:sticky;
            top:0;
            z-index:800;
            gap:15px;
            backdrop-filter:blur(12px);
            transform:none;
        }
        .mobile-menu,.desktop-menu{
            width:40px;height:40px;border:0;border-radius:9px;background:transparent;
            color:#243653;display:flex;align-items:center;justify-content:center;
            transition:background .2s ease
        }
        .mobile-menu{display:none;background:#f3f6fa}
        .mobile-menu:hover,.desktop-menu:hover{background:#eaf0fa}
        .topbar-spacer{flex:1}
        .profile-wrap{position:relative}
        .profile-trigger{display:flex;align-items:center;gap:10px;border:0;background:transparent;padding:6px 9px;border-radius:12px;text-align:left}
        .profile-trigger:hover,.profile-trigger[aria-expanded="true"]{background:#f2f6fc}
        .avatar{
            width:42px;height:42px;border-radius:50%;
            background:linear-gradient(135deg,#d9e6ff,#9ebcff);
            display:flex;align-items:center;justify-content:center;
            font-weight:800;color:#224c9c;overflow:hidden;flex-shrink:0
        }
        .profile-text strong{display:block;font-size:13px;color:#182543}
        .profile-text small{display:block;margin-top:4px;font-size:11px;color:#50658a}
        .chevron{width:15px;height:15px;color:#7182a3;transition:transform .2s ease}
        .profile-trigger[aria-expanded="true"] .chevron{transform:rotate(180deg)}
        .profile-dropdown{
            display:none;position:absolute;right:0;top:calc(100% + 9px);width:225px;
            background:white;border:1px solid #e0e7f1;border-radius:13px;padding:8px;
            box-shadow:0 16px 40px #17254120;z-index:1200
        }
        .profile-dropdown.show{display:block;animation:dropIn .2s ease both}
        @keyframes dropIn{from{opacity:0;transform:translateY(-7px) scale(.98)}to{opacity:1;transform:translateY(0) scale(1)}}
        .dropdown-heading{padding:10px 11px 12px;border-bottom:1px solid #edf1f7;margin-bottom:5px}
        .dropdown-heading strong{display:block;font-size:13px}
        .dropdown-heading small{display:block;color:#8290a8;font-size:11px;margin-top:4px}
        .dropdown-link{display:flex;align-items:center;gap:11px;padding:11px;border-radius:8px;font-size:12px;color:#344765;transition:background .18s ease}
        .dropdown-link:hover{background:#f2f6fc}
        .dropdown-link svg{width:17px;height:17px;color:#637795;flex-shrink:0}
        .dropdown-divider{height:1px;background:#edf1f7;margin:5px 0}
        .dropdown-link.logout{width:100%;border:0;background:white;text-align:left;color:#dc4353}
        .dropdown-link.logout:hover{background:#fff0f2}
        .content{padding:20px 25px 28px;max-width:1600px;margin:auto}
        .overlay{display:none}
        .overlay.show{display:block;position:fixed;inset:0;background:#0a142873;z-index:900}

        @media(min-width:1001px){
            .sidebar.collapsed{transform:translateX(-100%)}
            .main.sidebar-collapsed{margin-left:0}
        }
        @media(max-width:1000px){
            .sidebar{transform:translateX(-100%);box-shadow:none}
            .sidebar.open{transform:translateX(0);box-shadow:12px 0 35px #101b302b}
            .main{margin-left:0}
            .mobile-menu{display:flex}
            .desktop-menu{display:none}
        }
        @media(max-width:700px){
            .topbar{height:64px;padding:0 12px;gap:8px}
            .content{padding:14px}
            .profile-trigger{gap:7px;padding:4px}
            .avatar{width:39px;height:39px}
            .profile-text strong{font-size:11px}
            .profile-text small{font-size:10px}
            .chevron{display:none}
            .profile-dropdown{right:0;width:220px}
        }
        @media(max-width:390px){
            .profile-text{display:none}
        }
        @media(prefers-reduced-motion:reduce){
            *,*::before,*::after{animation-duration:.01ms!important;animation-iteration-count:1!important;scroll-behavior:auto!important;transition-duration:.01ms!important}
        }
    </style>

    @stack('styles')
</head>

<body>
@php
    $namaPelanggan = auth()->user()->name ?? 'Pelanggan';
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
        <div class="menu-label">MENU PELANGGAN</div>

        <a href="{{ route('dashboard') }}"
           class="menu-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
           onclick="tutupSidebarMobile()">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M3 11 12 4l9 7"/>
                <path d="M5 10v10h14V10"/>
                <path d="M9 20v-6h6v6"/>
            </svg>
            Dashboard
        </a>

        <a href="{{ route('booking.create') }}"
           class="menu-link {{ request()->routeIs('booking.create') ? 'active' : '' }}"
           onclick="tutupSidebarMobile()">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect x="3" y="4" width="18" height="17" rx="2"/>
                <path d="M8 2v4M16 2v4M3 10h18"/>
                <path d="M12 13v5M9.5 15.5h5"/>
            </svg>
            Booking Servis
        </a>

        <a href="{{ route('booking.index') }}"
           class="menu-link {{ request()->routeIs('booking.index') ? 'active' : '' }}"
           onclick="tutupSidebarMobile()">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect x="4" y="3" width="16" height="18" rx="2"/>
                <path d="M8 8h8M8 12h8M8 16h5"/>
            </svg>
            Riwayat Booking
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
                    <small>Pengaturan akun pelanggan</small>
                </div>

                <a href="{{ route('profile.edit') }}" class="dropdown-link">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="8" r="4"/>
                        <path d="M4 21c0-4 3.6-7 8-7s8 3 8 7"/>
                    </svg>
                    Profil Akun
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
</script>

@stack('scripts')
</body>
</html>