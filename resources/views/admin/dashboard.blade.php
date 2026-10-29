@extends('admin.layouts.app')

@section('title', 'Dashboard Admin')

@push('styles')
<style>
    .page-heading { gap: 20px; margin-bottom: 26px; align-items: center; }

    .dash-page,
    .dash-page * { box-sizing: border-box; }
    .dash-page { color: #212529; }

    /* ===== KARTU RINGKASAN ATAS ===== */
    .dash-page .kpi-grid { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 16px; margin-bottom: 18px; }
    .dash-page .kpi { display: flex; align-items: center; gap: 14px; min-width: 0; padding: 18px 20px; background: #fff; border: 1px solid #e9ecef; border-radius: 6px; box-shadow: 0 1px 4px rgba(0,0,0,.06); }
    .dash-page .kpi-icon { width: 50px; height: 50px; display: grid; place-items: center; flex-shrink: 0; border-radius: 8px; }
    .dash-page .kpi-title { color: #6c757d; font-size: 13px; font-weight: 600; }
    .dash-page .kpi-number { margin-top: 4px; color: #212529; font-size: clamp(24px, 2.5vw, 30px); font-weight: 700; line-height: 1.15; font-variant-numeric: tabular-nums; }
    .dash-page .kpi-desc { margin-top: 4px; color: #6c757d; font-size: 11px; }

    .dash-page .tone-blue   { background: #e7f1ff; color: #007bff; }
    .dash-page .tone-orange { background: #fff3cd; color: #d39e00; }
    .dash-page .tone-green  { background: #d4edda; color: #28a745; }
    .dash-page .tone-red    { background: #f8d7da; color: #dc3545; }

    /* ===== PANEL ===== */
    .dash-page .dash-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 16px; align-items: start; }
    .dash-page .today-panel { grid-column: 1 / -1; }
    .dash-page .panel { min-width: 0; margin-bottom: 0; overflow: hidden; background: #fff; border: 1px solid #e9ecef; border-radius: 6px; box-shadow: 0 1px 4px rgba(0,0,0,.06); }
    .dash-page .panel-header { padding: 14px 20px; background: #fff; border-bottom: 1px solid #e9ecef; }
    .dash-page .panel-header-top { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px; }
    .dash-page .panel-title { color: #212529; font-size: 16px; font-weight: 400; }
    .dash-page .panel-subtitle { margin-top: 3px; color: #6c757d; font-size: 12px; line-height: 1.6; }

    .dash-page .today-badge { padding: 6px 10px; color: #004085; background: #e7f1ff; border: 1px solid #b8daff; border-radius: 4px; font-size: 12px; font-weight: 600; white-space: nowrap; }

    /* ===== RINGKASAN ===== */
    .dash-page .summary-content { padding: 18px 20px 20px; }
    .dash-page .summary-item { display: flex; align-items: center; gap: 14px; margin-bottom: 12px; padding: 14px 16px; background: #fff; border: 1px solid #dee2e6; border-radius: 6px; }
    .dash-page .summary-item:hover { background: #f8f9fa; }
    .dash-page .summary-icon { width: 44px; height: 44px; display: grid; place-items: center; flex-shrink: 0; border-radius: 8px; }
    .dash-page .summary-label { color: #6c757d; font-size: 13px; font-weight: 600; }
    .dash-page .summary-number { margin-top: 3px; color: #212529; font-size: 24px; font-weight: 700; line-height: 1.2; font-variant-numeric: tabular-nums; }
    .dash-page .summary-desc { margin-top: 3px; color: #6c757d; font-size: 11px; }
    .dash-page .summary-link { display: flex; align-items: center; justify-content: center; gap: 8px; min-height: 38px; margin-top: 16px; padding: 8px 14px; color: #fff; background: #007bff; border: 1px solid #007bff; border-radius: 4px; font-size: 14px; font-weight: 600; text-decoration: none; transition: filter .15s ease; }
    .dash-page .summary-link:hover { filter: brightness(.92); }

    /* ===== JADWAL SERVIS HARI INI ===== */
    .dash-page .today-list { padding: 16px 20px; display: grid; gap: 10px; }
    .dash-page .today-item { display: grid; grid-template-columns: 84px minmax(0, 1.6fr) minmax(0, 1fr) auto; align-items: center; gap: 16px; padding: 12px 14px; background: #fff; border: 1px solid #dee2e6; border-radius: 6px; }
    .dash-page .today-item:hover { background: #f8f9fa; }
    .dash-page .today-time { padding: 8px; color: #004085; background: #e7f1ff; border-radius: 6px; font-size: 16px; font-weight: 700; text-align: center; font-variant-numeric: tabular-nums; }
    .dash-page .today-time small { display: block; margin-top: 2px; font-size: 9px; font-weight: 700; letter-spacing: .5px; }
    .dash-page .customer-name { display: block; color: #212529; font-size: 14px; font-weight: 700; overflow-wrap: anywhere; }
    .dash-page .customer-detail { display: block; margin-top: 3px; color: #6c757d; font-size: 12px; line-height: 1.6; overflow-wrap: anywhere; }
    .dash-page .today-mech small { display: block; margin-bottom: 3px; color: #6c757d; font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: .4px; }
    .dash-page .today-mech strong { color: #212529; font-size: 13px; overflow-wrap: anywhere; }
    .dash-page .today-mech strong.muted { color: #6c757d; font-weight: 500; }

    .dash-page .status { display: inline-flex; align-items: center; gap: 5px; padding: 5px 9px; border: 1px solid transparent; border-radius: 4px; font-size: 11px; font-weight: 700; white-space: nowrap; }
    .dash-page .status.waiting { color: #856404; background: #fff3cd; border-color: #ffeeba; }
    .dash-page .status.process { color: #0c5460; background: #d1ecf1; border-color: #bee5eb; }
    .dash-page .status.done    { color: #155724; background: #d4edda; border-color: #c3e6cb; }

    .dash-page .today-more { padding: 0 20px 14px; color: #6c757d; font-size: 12px; }
    .dash-page .empty-state { padding: 34px 15px; color: #6c757d; text-align: center; font-size: 13px; line-height: 1.7; }
    .dash-page .panel-footer { display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px; padding: 14px 20px; background: #f8f9fa; border-top: 1px solid #e9ecef; color: #6c757d; font-size: 12px; }
    .dash-page .panel-footer a { color: #007bff; font-weight: 700; text-decoration: none; }
    .dash-page .panel-footer a:hover { text-decoration: underline; }

    /* ===== RESPONSIF ===== */
    @media (max-width: 1100px) {
        .dash-page .kpi-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .dash-page .kpi:last-child:nth-child(odd) { grid-column: 1 / -1; }
        .dash-page .dash-grid { grid-template-columns: minmax(0, 1fr); }
        .dash-page .today-panel { grid-column: auto; }
    }

    /* Jadwal di HP: jam + status di baris atas, lalu nama, lalu mekanik */
    @media (max-width: 760px) {
        .dash-page .today-item {
            grid-template-columns: auto minmax(0, 1fr);
            grid-template-areas: "time status" "info info" "mech mech";
            gap: 10px 12px;
        }
        .dash-page .today-time { grid-area: time; justify-self: start; padding: 6px 12px; font-size: 15px; }
        .dash-page .today-time small { display: inline; margin: 0 0 0 5px; }
        .dash-page .today-info { grid-area: info; }
        .dash-page .today-mech { grid-area: mech; padding-top: 10px; border-top: 1px dashed #dee2e6; }
        .dash-page .today-item .status { grid-area: status; justify-self: end; }
    }

    @media (max-width: 650px) {
        .page-heading { align-items: stretch; }
        .dash-page .kpi-grid { grid-template-columns: minmax(0, 1fr); gap: 10px; }
        .dash-page .kpi:last-child:nth-child(odd) { grid-column: auto; }
        .dash-page .kpi { padding: 14px 16px; gap: 12px; }
        .dash-page .kpi-icon { width: 44px; height: 44px; }
        .dash-page .panel-header { padding: 12px 14px; }
        .dash-page .summary-content { padding: 14px; }
        .dash-page .summary-item { padding: 12px; }
        .dash-page .summary-link { min-height: 42px; }
        .dash-page .today-list { padding: 12px; }
        .dash-page .today-more { padding: 0 14px 12px; }
        .dash-page .panel-footer { padding: 12px 14px; }
        .dash-page .today-badge { white-space: normal; }
    }
</style>
@endpush

@section('content')
@php
    $totalBooking = $bookings->count();

    $bookingMenunggu = $bookings->filter(function ($booking) {
        return in_array(strtolower($booking->status ?? ''), ['menunggu', 'pending']);
    })->count();

    $servisSelesai = $bookings->filter(function ($booking) {
        return strtolower($booking->status ?? '') === 'selesai';
    })->count();

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

    // Jadwal servis hari ini (tanpa pesanan ditolak / dibatalkan), urut dari jam paling awal
    $jadwalHariIni = $bookings->filter(function ($item) use ($tanggalHariIni) {
        $st = strtolower($item->status ?? '');

        return $item->tanggal_booking
            && \Carbon\Carbon::parse($item->tanggal_booking)->toDateString() === $tanggalHariIni
            && ! in_array($st, ['ditolak', 'dibatalkan', 'batal']);
    })->sortBy(function ($item) {
        return str_replace(',', ':', (string) $item->jam_booking);
    })->values();

    $jadwalTampil = $jadwalHariIni->take(8);
    $jadwalSisa = $jadwalHariIni->count() - $jadwalTampil->count();

    // Warna label status
    $kelasStatus = function ($status) {
        return match (strtolower(trim((string) $status))) {
            'selesai' => 'done',
            'disetujui', 'diterima', 'proses', 'diproses',
            'sedang dikerjakan', 'dikerjakan' => 'process',
            default => 'waiting',
        };
    };

    // Link ke halaman jadwal servis (dicek dulu agar tidak error bila nama route berbeda)
    $linkJadwal = '#';
    foreach (['admin.jadwal-servis', 'admin.jadwal'] as $namaRoute) {
        if (\Illuminate\Support\Facades\Route::has($namaRoute)) {
            $linkJadwal = route($namaRoute);
            break;
        }
    }
@endphp

<section class="page-heading">
    <div>
        <div class="breadcrumb">Admin / Dashboard</div>
        <h1 class="page-title">Ringkasan Operasional Bengkel</h1>
        <p class="page-description">Pantau ringkasan booking, data mekanik, dan jadwal servis hari ini dalam satu tempat.</p>
    </div>
</section>

<div class="dash-page">

    {{-- KARTU RINGKASAN ATAS --}}
    <section class="kpi-grid">
        <div class="kpi">
            <div class="kpi-icon tone-blue">
                <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <rect x="3" y="4" width="18" height="17" rx="2"/><path d="M8 2v4M16 2v4M3 10h18"/>
                </svg>
            </div>
            <div>
                <div class="kpi-title">Total Booking</div>
                <div class="kpi-number">{{ $totalBooking }}</div>
                <div class="kpi-desc">Semua pesanan pelanggan</div>
            </div>
        </div>

        <div class="kpi">
            <div class="kpi-icon tone-orange">
                <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/>
                </svg>
            </div>
            <div>
                <div class="kpi-title">Booking Menunggu</div>
                <div class="kpi-number">{{ $bookingMenunggu }}</div>
                <div class="kpi-desc">Booking yang belum ditangani</div>
            </div>
        </div>

        <div class="kpi">
            <div class="kpi-icon tone-green">
                <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <circle cx="12" cy="12" r="9"/><path d="m8 12 2.5 2.5L16 9"/>
                </svg>
            </div>
            <div>
                <div class="kpi-title">Servis Selesai</div>
                <div class="kpi-number">{{ $servisSelesai }}</div>
                <div class="kpi-desc">Pesanan yang sudah selesai</div>
            </div>
        </div>
    </section>

    <section class="dash-grid">

        {{-- RINGKASAN BOOKING --}}
        <section class="panel">
            <div class="panel-header">
                <div class="panel-title">Ringkasan Booking</div>
                <div class="panel-subtitle">Informasi booking pelanggan untuk memantau operasional bengkel.</div>
            </div>

            <div class="summary-content">
                <div class="summary-item">
                    <div class="summary-icon tone-blue">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <rect x="3" y="4" width="18" height="17" rx="2"/><path d="M8 2v4M16 2v4M3 10h18"/>
                        </svg>
                    </div>
                    <div>
                        <div class="summary-label">Booking Hari Ini</div>
                        <div class="summary-number">{{ $bookingHariIni }}</div>
                        <div class="summary-desc">Booking dengan tanggal hari ini</div>
                    </div>
                </div>

                <div class="summary-item">
                    <div class="summary-icon tone-orange">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/>
                        </svg>
                    </div>
                    <div>
                        <div class="summary-label">Perlu Ditangani</div>
                        <div class="summary-number">{{ $bookingMenunggu }}</div>
                        <div class="summary-desc">Booking yang masih menunggu</div>
                    </div>
                </div>

                <a href="{{ route('admin.pelanggan-pesanan') }}" class="summary-link">
                    Lihat Daftar Pesanan <span aria-hidden="true">→</span>
                </a>
            </div>
        </section>

        {{-- RINGKASAN MEKANIK --}}
        <section class="panel">
            <div class="panel-header">
                <div class="panel-title">Ringkasan Mekanik</div>
                <div class="panel-subtitle">Pantau jumlah mekanik berdasarkan statusnya.</div>
            </div>

            <div class="summary-content">
                <div class="summary-item">
                    <div class="summary-icon tone-green">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path d="m5 12 4 4L19 6"/>
                        </svg>
                    </div>
                    <div>
                        <div class="summary-label">Mekanik Aktif</div>
                        <div class="summary-number">{{ $mekanikAktif }}</div>
                        <div class="summary-desc">Status mekanik aktif</div>
                    </div>
                </div>

                <div class="summary-item">
                    <div class="summary-icon tone-red">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path d="M6 6l12 12M18 6 6 18"/>
                        </svg>
                    </div>
                    <div>
                        <div class="summary-label">Mekanik Nonaktif</div>
                        <div class="summary-number">{{ $mekanikNonaktif }}</div>
                        <div class="summary-desc">Status mekanik nonaktif</div>
                    </div>
                </div>

                <a href="{{ route('admin.mekanik.index') }}" class="summary-link">
                    Lihat Data Mekanik <span aria-hidden="true">→</span>
                </a>
            </div>
        </section>

        {{-- JADWAL SERVIS HARI INI --}}
        <section class="panel today-panel">
            <div class="panel-header">
                <div class="panel-header-top">
                    <div>
                        <div class="panel-title">Jadwal Servis Hari Ini</div>
                        <div class="panel-subtitle">Urut dari jam paling awal. Pesanan ditolak dan dibatalkan tidak ditampilkan.</div>
                    </div>

                    <span class="today-badge">
                        {{ $jadwalHariIni->count() }} Jadwal · {{ now()->format('d M Y') }}
                    </span>
                </div>
            </div>

            @if ($jadwalHariIni->isEmpty())
                <div class="empty-state">
                    Belum ada jadwal servis untuk hari ini.
                </div>
            @else
                <div class="today-list">
                    @foreach ($jadwalTampil as $item)
                        @php
                            $jam = substr(str_replace(',', ':', (string) $item->jam_booking), 0, 5);
                            $namaMekanik = $item->mechanic?->nama_mekanik;
                            $namaServis = $item->service?->nama_servis ?? $item->jenis_servis;
                        @endphp

                        <div class="today-item">
                            <div class="today-time">
                                {{ $jam ?: '-' }}
                                <small>WIB</small>
                            </div>

                            <div class="today-info">
                                <span class="customer-name">{{ $item->nama_pelanggan ?: '-' }}</span>
                                <span class="customer-detail">
                                    {{ $item->nama_motor ?: '-' }}
                                    · {{ $item->plat_nomor ?: '-' }}
                                    @if ($namaServis)
                                        · {{ $namaServis }}
                                    @endif
                                </span>
                            </div>

                            <div class="today-mech">
                                <small>Mekanik</small>
                                <strong class="{{ $namaMekanik ? '' : 'muted' }}">
                                    {{ $namaMekanik ?: 'Belum ditentukan' }}
                                </strong>
                            </div>

                            <span class="status {{ $kelasStatus($item->status) }}">
                                {{ ucfirst($item->status ?? 'Menunggu') }}
                            </span>
                        </div>
                    @endforeach
                </div>

                @if ($jadwalSisa > 0)
                    <div class="today-more">+ {{ $jadwalSisa }} jadwal lainnya hari ini</div>
                @endif
            @endif

            <div class="panel-footer">
                <span>Data diambil dari booking dengan tanggal hari ini.</span>
                <a href="{{ $linkJadwal }}">Lihat jadwal lengkap →</a>
            </div>
        </section>

    </section>
</div>
@endsection