<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pelanggan - Bengkel Royal Motor</title>

    <style>
        *{margin:0;padding:0;box-sizing:border-box}
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
        .menu-link:hover{background:#ffffff14;transform:translateX(3px)}
        .menu-link.active{background:linear-gradient(90deg,#3567d9,#355dbb);box-shadow:0 7px 22px #305fd059}
        .sidebar-footer{padding:18px 20px;border-top:1px solid #ffffff14;font-size:10px;line-height:1.7;color:#aeb9cf}
        .main{margin-left:278px;min-height:100vh;transition:margin-left .3s ease}
        .topbar{
            height:72px;background:#fffffff5;border-bottom:1px solid #e7edf5;
            display:flex;align-items:center;padding:0 25px;position:sticky;top:0;
            z-index:800;gap:15px;backdrop-filter:blur(12px)
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
        @keyframes fadeUp{from{opacity:0;transform:translateY(12px)}to{opacity:1;transform:translateY(0)}}
        .welcome,.stat-card,.info-card{animation:fadeUp .45s ease both}
        .welcome{animation-delay:.02s}
        .welcome{
            min-height:100px;border:1px solid #c7ddfa;border-radius:14px;
            background:linear-gradient(110deg,#c3d8ff,#dff4ff);
            display:flex;align-items:center;justify-content:space-between;
            gap:15px;padding:16px 22px;margin-bottom:16px;
            box-shadow:0 5px 16px #325da40b
        }
        .welcome-left{display:flex;align-items:center;gap:15px}
        .welcome-hand{width:48px;height:48px;border-radius:13px;background:#ffffffa8;color:#2d5eb8;display:flex;align-items:center;justify-content:center;flex-shrink:0}
        .welcome h1{font-size:24px;color:#102143;line-height:1.3}
        .welcome p{margin-top:6px;font-size:12px;color:#3d5790;line-height:1.6}
        .date-box{min-width:230px;background:#ffffffc9;border:1px solid #b8d3f2d9;border-radius:13px;padding:12px 14px;display:flex;align-items:center;gap:12px}
        .date-icon{width:38px;height:38px;border-radius:11px;background:#e5efff;color:#3b65bc;display:flex;align-items:center;justify-content:center;flex-shrink:0}
        .date-text{font-size:11px;color:#46618e;margin-bottom:5px}
        .time-text{font-size:16px;font-weight:800;font-variant-numeric:tabular-nums}
        .stats{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:16px;margin-bottom:20px}
        .stat-card{
            min-height:120px;background:white;border-radius:14px;border:1px solid #dae3ee;
            box-shadow:0 5px 14px #273d630f;padding:17px;display:flex;align-items:flex-start;
            transition:transform .25s ease,box-shadow .25s ease
        }
        .stat-card:hover{transform:translateY(-4px);box-shadow:0 13px 28px #20396218}
        .stat-card:nth-child(2){animation-delay:.07s}
        .stat-card:nth-child(3){animation-delay:.14s}
        .stat-icon{width:51px;height:51px;border-radius:15px;display:flex;align-items:center;justify-content:center;margin-right:14px;flex-shrink:0}
        .stat-blue .stat-icon{color:#3580ff;background:#e2eeff}
        .stat-orange .stat-icon{color:#ff8d11;background:#fff1dc}
        .stat-green .stat-icon{color:#12a77b;background:#def6ed}
        .stat-orange{border-bottom:2px solid #f7a11a}
        .stat-green{border-bottom:2px solid #21b989}
        .stat-title{font-size:13px;font-weight:700}
        .stat-number{font-size:29px;margin-top:8px;font-weight:800}
        .stat-description{font-size:10px;margin-top:7px;color:#4c689b}

        /* INFORMASI BENGKEL */
        .section-heading{margin:26px 0 14px}
        .section-heading h2{font-size:20px;font-weight:800;color:#14213d}
        .section-heading p{font-size:12px;color:#7182a3;line-height:1.7;margin-top:6px}
        .info-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:16px}
        .info-card{
            background:white;border:1px solid var(--border);border-radius:14px;
            overflow:hidden;box-shadow:0 5px 16px #273d630d;min-width:0
        }
        .info-card.full{grid-column:1/-1}
        .info-card-header{padding:16px 18px;border-bottom:1px solid #e4eaf2}
        .info-card-header h3{font-size:15px;font-weight:800;color:#14213d}
        .info-card-header p{font-size:11px;color:var(--muted);margin-top:5px;line-height:1.6}
        .info-card-body{padding:18px;font-size:12px;line-height:1.9;color:#50617d;overflow-wrap:anywhere}
        .workshop-photo{width:100%;height:220px;object-fit:cover;display:block;background:#edf2f8}
        .photo-caption{padding:12px 16px;font-size:12px;line-height:1.7;color:#50617d;border-top:1px solid #edf1f7}
        .operational-status{display:inline-flex;padding:7px 12px;border-radius:20px;font-size:11px;font-weight:800;margin-bottom:12px}
        .operational-status.open{color:#16865f;background:#def6ed}
        .operational-status.closed{color:#c52f47;background:#ffe5e9}
        .operational-status.unknown{color:#a36a00;background:#fff2d7}
        .info-list{list-style:none}
        .info-list li{padding:10px 0;border-bottom:1px solid #edf1f7}
        .info-list li:first-child{padding-top:0}
        .info-list li:last-child{border-bottom:0}
        .info-list strong{color:#14213d}
        .announcement-item{padding:13px 0;border-bottom:1px solid #edf1f7}
        .announcement-item:first-child{padding-top:0}
        .announcement-item:last-child{border-bottom:0;padding-bottom:0}
        .announcement-item h4{color:#14213d;font-size:13px;margin-bottom:5px}
        .announcement-date{font-size:10px;color:var(--muted);margin-bottom:7px}
        .info-empty{padding:18px;text-align:center;font-size:12px;line-height:1.8;color:var(--muted)}
        .info-footer{padding:13px 18px;border-top:1px solid #edf1f7;font-size:10px;color:#7184a8;line-height:1.7}
        .info-footer strong{color:#3264d8}
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
            .stats{grid-template-columns:repeat(2,minmax(0,1fr))}
        }
        @media(max-width:700px){
            .topbar{height:64px;padding:0 12px;gap:8px}
            .content{padding:14px}
            .profile-trigger{gap:7px;padding:4px}
            .avatar{width:39px;height:39px}
            .profile-text strong{font-size:11px}
            .profile-text small{font-size:10px}
            .chevron{display:none}
            .welcome{align-items:stretch;flex-direction:column;padding:17px}
            .welcome h1{font-size:20px}
            .date-box{width:100%;min-width:0}
            .stats{grid-template-columns:1fr;gap:11px}
            .stat-card{min-height:105px}
            .profile-dropdown{right:0;width:220px}
            .info-grid{grid-template-columns:1fr;gap:12px}
            .info-card.full{grid-column:auto}
            .info-card-header,.info-card-body{padding:14px}
            .workshop-photo{height:190px}
            .section-heading h2{font-size:18px}
        }
        @media(max-width:390px){
            .profile-text{display:none}
            .welcome h1{font-size:18px}
            .welcome-left{align-items:flex-start}
        }
        @media(prefers-reduced-motion:reduce){
            *,*::before,*::after{animation-duration:.01ms!important;animation-iteration-count:1!important;scroll-behavior:auto!important;transition-duration:.01ms!important}
        }
    </style>
</head>

<body>
@php
    $bookings = $bookings ?? collect();

    $totalBooking = $bookings->count();

    $totalProses = $bookings->filter(function ($booking) {
        return in_array(strtolower($booking->status ?? ''), [
            'proses', 'diproses', 'sedang dikerjakan',
            'dikerjakan', 'disetujui', 'diterima'
        ]);
    })->count();

    $totalSelesai = $bookings->filter(function ($booking) {
        return strtolower($booking->status ?? '') === 'selesai';
    })->count();

    $namaPelanggan = auth()->user()->name ?? 'Pelanggan';
    $informasiBengkel = $informasiBengkel ?? null;
    $namaBengkel = $informasiBengkel?->nama_bengkel ?? 'Bengkel Royal Motor';
    $jamOperasional = $jamOperasional
        ?? (($informasiBengkel?->jam_buka && $informasiBengkel?->jam_tutup)
            ? $informasiBengkel->jam_buka.' - '.$informasiBengkel->jam_tutup.' WIB'
            : '13.00 - 22.00 WIB');
    $statusOperasional = $statusOperasional
        ?? $informasiBengkel?->status_operasional
        ?? 'belum diatur';
    $pengumuman = $pengumuman ?? collect();
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
           class="menu-link active"
           onclick="tutupSidebarMobile()">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M3 11 12 4l9 7"/>
                <path d="M5 10v10h14V10"/>
                <path d="M9 20v-6h6v6"/>
            </svg>
            Dashboard
        </a>

        <a href="{{ route('booking.create') }}"
           class="menu-link"
           onclick="tutupSidebarMobile()">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect x="3" y="4" width="18" height="17" rx="2"/>
                <path d="M8 2v4M16 2v4M3 10h18"/>
                <path d="M12 13v5M9.5 15.5h5"/>
            </svg>
            Booking Servis
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
                <div class="avatar">{{ strtoupper(substr($namaPelanggan, 0, 1)) }}</div>

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
        <section class="welcome">
            <div class="welcome-left">
                <div class="welcome-hand" aria-hidden="true">
                    <svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M4 19V5M4 19h16"/>
                        <path d="m7 15 4-4 3 2 5-6"/>
                        <path d="M16 7h3v3"/>
                    </svg>
                </div>

                <div>
                    <h1>Dashboard Pelanggan</h1>
                    <p>
                        Selamat datang kembali, <strong>{{ $namaPelanggan }}</strong>!
                        Lihat informasi bengkel dan pantau booking servis Anda.
                    </p>
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

        <!-- STATISTIK BOOKING -->
        <section class="stats">
            <div class="stat-card stat-blue">
                <div class="stat-icon">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="4" width="18" height="17" rx="2"/>
                        <path d="M8 2v4M16 2v4M3 10h18"/>
                    </svg>
                </div>
                <div>
                    <div class="stat-title">Total Booking Saya</div>
                    <div class="stat-number">{{ $totalBooking }}</div>
                    <div class="stat-description">Semua pengajuan servis Anda</div>
                </div>
            </div>

            <div class="stat-card stat-orange">
                <div class="stat-icon">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="9"/>
                        <path d="M12 7v5l3 2"/>
                    </svg>
                </div>
                <div>
                    <div class="stat-title">Status Diproses</div>
                    <div class="stat-number">{{ $totalProses }}</div>
                    <div class="stat-description">Booking yang sedang ditangani</div>
                </div>
            </div>

            <div class="stat-card stat-green">
                <div class="stat-icon">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="9"/>
                        <path d="m8 12 2.5 2.5L16 9"/>
                    </svg>
                </div>
                <div>
                    <div class="stat-title">Servis Selesai</div>
                    <div class="stat-number">{{ $totalSelesai }}</div>
                    <div class="stat-description">Pesanan yang sudah selesai</div>
                </div>
            </div>
        </section>

        <!-- INFORMASI BENGKEL -->
        <div class="section-heading">
            <h2>Informasi Bengkel</h2>
            <p>Kenali Bengkel Royal Motor, lihat jam operasional, dan baca informasi terbaru sebelum datang untuk servis.</p>
        </div>

        <div class="info-grid">

            <!-- PROFIL BENGKEL -->
            <section class="info-card">
                <div class="info-card-header">
                    <h3>{{ $namaBengkel }}</h3>
                    <p>Profil dan informasi umum bengkel</p>
                </div>

                @if(!empty($informasiBengkel?->foto_1))
                    <img
                        src="{{ asset('storage/'.$informasiBengkel->foto_1) }}"
                        alt="Foto Bengkel Royal Motor"
                        class="workshop-photo"
                    >
                @endif

                <div class="info-card-body">
                    {{ $informasiBengkel?->deskripsi
                        ?: 'Selamat datang di Bengkel Royal Motor. Kami menyediakan layanan servis dan perawatan sepeda motor untuk membantu menjaga kendaraan Anda tetap nyaman digunakan.' }}
                </div>

                @if(!empty($informasiBengkel?->deskripsi_foto_1))
                    <div class="photo-caption">{{ $informasiBengkel->deskripsi_foto_1 }}</div>
                @endif

                <div class="info-footer">
                    <strong>Bengkel Royal Motor</strong><br>
                    Servis Motor, Solusi Perjalananmu.
                </div>
            </section>

            <!-- JAM OPERASIONAL -->
            <section class="info-card">
                <div class="info-card-header">
                    <h3>Jam Operasional</h3>
                    <p>Jadwal pelayanan Bengkel Royal Motor</p>
                </div>

                <div class="info-card-body">
                    @if(strtolower($statusOperasional) === 'buka')
                        <span class="operational-status open">● SEDANG BUKA</span>
                    @elseif(strtolower($statusOperasional) === 'tutup')
                        <span class="operational-status closed">● SEDANG TUTUP</span>
                    @else
                        <span class="operational-status unknown">● BELUM DIATUR</span>
                    @endif

                    <ul class="info-list">
                        <li>
                            <strong>Hari operasional</strong><br>
                            {{ $informasiBengkel?->hari_operasional ?? 'Senin–Minggu' }}
                        </li>
                        <li>
                            <strong>Jam pelayanan</strong><br>
                            {{ $jamOperasional }}
                        </li>
                        <li>
                            <strong>Status bengkel</strong><br>
                            {{ strtoupper($statusOperasional) }}
                        </li>
                    </ul>
                </div>

                <div class="info-footer">
                    Silakan perhatikan jadwal operasional sebelum berkunjung ke bengkel.
                </div>
            </section>

            <!-- INFORMASI LAYANAN -->
            <section class="info-card">
                <div class="info-card-header">
                    <h3>Informasi Layanan</h3>
                    <p>Informasi layanan yang tersedia</p>
                </div>

                @if(!empty($informasiBengkel?->foto_2))
                    <img
                        src="{{ asset('storage/'.$informasiBengkel->foto_2) }}"
                        alt="Informasi layanan Bengkel Royal Motor"
                        class="workshop-photo"
                    >
                @endif

                <div class="info-card-body">
                    @if(!empty($informasiBengkel?->informasi_layanan))
                        {{ $informasiBengkel->informasi_layanan }}
                    @else
                        <ul class="info-list">
                            <li>
                                <strong>Servis dan perawatan</strong><br>
                                Perawatan sepeda motor sesuai kebutuhan kendaraan.
                            </li>
                            <li>
                                <strong>Pemeriksaan kendaraan</strong><br>
                                Pemeriksaan kondisi kendaraan dan keluhan pelanggan.
                            </li>
                            <li>
                                <strong>Konsultasi servis</strong><br>
                                Sampaikan keluhan kendaraan saat melakukan booking.
                            </li>
                        </ul>
                    @endif
                </div>

                @if(!empty($informasiBengkel?->deskripsi_foto_2))
                    <div class="photo-caption">{{ $informasiBengkel->deskripsi_foto_2 }}</div>
                @endif

                <div class="info-footer">
                    <a href="{{ route('booking.create') }}"><strong>Booking servis sekarang →</strong></a>
                </div>
            </section>

            <!-- PENGUMUMAN -->
            <section class="info-card">
                <div class="info-card-header">
                    <h3>Pengumuman Bengkel</h3>
                    <p>Informasi terbaru untuk pelanggan</p>
                </div>

                <div class="info-card-body">
                    @forelse($pengumuman as $item)
                        <div class="announcement-item">
                            <h4>{{ $item->judul }}</h4>

                            <div class="announcement-date">
                                {{ $item->created_at?->format('d M Y') ?? '' }}
                            </div>

                            <div>{{ $item->isi }}</div>
                        </div>
                    @empty
                        <div class="info-empty">
                            Belum ada pengumuman dari bengkel.
                        </div>
                    @endforelse
                </div>

                <div class="info-footer">
                    Periksa bagian ini secara berkala untuk melihat pengumuman terbaru.
                </div>
            </section>

            <!-- GALERI BENGKEL -->
            @if(!empty($informasiBengkel?->foto_2))
                <section class="info-card full">
                    <div class="info-card-header">
                        <h3>Galeri Bengkel</h3>
                        <p>Foto tambahan Bengkel Royal Motor</p>
                    </div>

                    <img
                        src="{{ asset('storage/'.$informasiBengkel->foto_2) }}"
                        alt="Galeri Bengkel Royal Motor"
                        class="workshop-photo"
                    >

                    @if(!empty($informasiBengkel?->deskripsi_foto_2))
                        <div class="photo-caption">{{ $informasiBengkel->deskripsi_foto_2 }}</div>
                    @endif
                </section>
            @endif

        </div>
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