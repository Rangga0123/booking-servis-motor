@extends('admin.layouts.app')

@section('title', 'Dashboard Admin')

@push('styles')
<style>
    .dash-page {
        --dash-card: #ffffff;
        --dash-text: #17243c;
        --dash-border: #e2e8f1;
        color: var(--dash-text);
    }

    .dash-page,
    .dash-page * { box-sizing: border-box; }

    .page-heading {
        gap: 20px;
        margin-bottom: 26px;
        align-items: center;
    }

    /* KARTU RINGKASAN ATAS */
    .dash-page .kpi-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 18px;
        margin-bottom: 22px;
    }

    .dash-page .kpi {
        position: relative;
        display: flex;
        align-items: center;
        gap: 17px;
        min-width: 0;
        padding: 24px 22px;
        overflow: hidden;
        background: var(--dash-card);
        border: 1px solid var(--dash-border);
        border-radius: 18px;
        box-shadow: 0 5px 20px rgba(31, 52, 88, .045);
        transition: transform .2s ease, box-shadow .2s ease;
    }

    .dash-page .kpi:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 28px rgba(31, 52, 88, .09);
    }

    .dash-page .kpi::after {
        content: "";
        position: absolute;
        right: -25px;
        top: -35px;
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background: currentColor;
        opacity: .035;
        pointer-events: none;
    }

    .dash-page .kpi-icon {
        width: 58px;
        height: 58px;
        display: grid;
        place-items: center;
        flex-shrink: 0;
        border-radius: 17px;
    }

    .dash-page .kpi-title { font-size: 13px; font-weight: 700; color: #75839a; }

    .dash-page .kpi-number {
        margin-top: 7px;
        font-size: clamp(25px, 2.5vw, 32px);
        line-height: 1.15;
        font-weight: 800;
        letter-spacing: -1px;
        color: #17243c;
        font-variant-numeric: tabular-nums;
    }

    .dash-page .kpi-desc { margin-top: 7px; font-size: 11px; color: #94a0b2; }

    .dash-page .tone-blue   { background: #e9efff; color: #4978f5; }
    .dash-page .tone-orange { background: #fff2df; color: #e69a28; }
    .dash-page .tone-green  { background: #e1f7ec; color: #17a875; }
    .dash-page .tone-red    { background: #ffe8ec; color: #e34e65; }

    /* PANEL */
    .dash-page .dash-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 20px;
        align-items: start;
    }

    .dash-page .today-panel { grid-column: 1 / -1; }

    .dash-page .panel {
        min-width: 0;
        margin-bottom: 0;
        overflow: hidden;
        background: #fff;
        border: 1px solid #e3e9f2;
        border-radius: 18px;
        box-shadow: 0 5px 22px rgba(31, 52, 88, .045);
    }

    .dash-page .panel-header {
        padding: 21px 23px;
        background: linear-gradient(135deg, #ffffff, #f9fbff);
        border-bottom: 1px solid #edf1f7;
    }

    .dash-page .panel-header-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 14px;
    }

    .dash-page .panel-heading { display: flex; align-items: center; gap: 14px; min-width: 0; }

    .dash-page .panel-heading-icon {
        width: 45px;
        height: 45px;
        display: grid;
        place-items: center;
        flex-shrink: 0;
        border-radius: 14px;
        background: linear-gradient(145deg, #527fff, #3158cb);
        color: white;
        box-shadow: 0 5px 12px #3f6fe52a;
    }

    .dash-page .panel-title { color: #1a2943; font-size: 15px; font-weight: 800; }
    .dash-page .panel-subtitle { margin-top: 5px; color: #8794a9; font-size: 12px; line-height: 1.6; }

    .dash-page .today-badge {
        padding: 8px 13px;
        border: 1px solid #e0e9ff;
        border-radius: 10px;
        background: #edf3ff;
        color: #456cce;
        font-size: 11px;
        font-weight: 800;
        white-space: nowrap;
    }

    /* RINGKASAN */
    .dash-page .summary-content { padding: 21px; }

    .dash-page .summary-item {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 13px;
        padding: 17px;
        background: #fafbfe;
        border: 1px solid #e9edf5;
        border-radius: 14px;
        transition: background .2s ease, border-color .2s ease;
    }

    .dash-page .summary-item:hover { background: #f5f8ff; border-color: #dbe5ff; }

    .dash-page .summary-icon {
        width: 49px;
        height: 49px;
        display: grid;
        place-items: center;
        flex-shrink: 0;
        border-radius: 14px;
    }

    .dash-page .summary-label { color: #697a95; font-size: 13px; font-weight: 700; }

    .dash-page .summary-number {
        margin-top: 5px;
        color: #192740;
        font-size: 26px;
        font-weight: 800;
        line-height: 1.2;
        font-variant-numeric: tabular-nums;
    }

    .dash-page .summary-desc { margin-top: 5px; color: #95a0b2; font-size: 11px; }

    .dash-page .summary-link {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        margin-top: 17px;
        padding: 14px 16px;
        color: #426ee4;
        background: #edf3ff;
        border: 1px solid #e1eaff;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 800;
        text-decoration: none;
        transition: .2s ease;
    }

    .dash-page .summary-link:hover { background: #e1eaff; transform: translateX(2px); }

    /* JADWAL SERVIS HARI INI */
    .dash-page .today-list { padding: 18px 21px; display: grid; gap: 12px; }

    .dash-page .today-item {
        display: grid;
        grid-template-columns: 90px minmax(0, 1.6fr) minmax(0, 1fr) auto;
        align-items: center;
        gap: 16px;
        padding: 14px 16px;
        background: #fafbfe;
        border: 1px solid #e9edf5;
        border-radius: 14px;
        transition: background .2s ease, border-color .2s ease;
    }

    .dash-page .today-item:hover { background: #f5f8ff; border-color: #dbe5ff; }

    .dash-page .today-time {
        padding: 10px 8px;
        border-radius: 11px;
        background: #e9efff;
        color: #3864d2;
        font-size: 17px;
        font-weight: 800;
        text-align: center;
        font-variant-numeric: tabular-nums;
    }

    .dash-page .today-time small { display: block; margin-top: 2px; font-size: 9px; font-weight: 700; letter-spacing: .5px; }

    .dash-page .customer-name {
        display: block;
        color: #263650;
        font-size: 13px;
        font-weight: 800;
        overflow-wrap: anywhere;
    }

    .dash-page .customer-detail {
        display: block;
        margin-top: 5px;
        color: #91a0b7;
        font-size: 11px;
        line-height: 1.6;
        overflow-wrap: anywhere;
    }

    .dash-page .today-mech small {
        display: block;
        margin-bottom: 4px;
        color: #91a0b7;
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .4px;
    }

    .dash-page .today-mech strong { color: #3c4a63; font-size: 12px; overflow-wrap: anywhere; }
    .dash-page .today-mech strong.muted { color: #9aa6b8; font-weight: 600; }

    .dash-page .status {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 7px 10px;
        border-radius: 8px;
        font-size: 10px;
        font-weight: 800;
        white-space: nowrap;
    }

    .dash-page .status.waiting { background: #fff3dc; color: #b9790b; }
    .dash-page .status.process { background: #eaf0ff; color: #3864d2; }
    .dash-page .status.done    { background: #e0f7eb; color: #138453; }

    .dash-page .today-more { padding: 0 21px 16px; color: #8996aa; font-size: 12px; }

    .dash-page .empty-state {
        padding: 34px 15px;
        color: #8a97ab;
        text-align: center;
        font-size: 13px;
        line-height: 1.7;
    }

    .dash-page .panel-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
        padding: 16px 21px;
        background: #fafbfe;
        border-top: 1px solid #edf1f6;
        color: #8996aa;
        font-size: 12px;
    }

    .dash-page .panel-footer a { color: #416fe8; font-weight: 800; text-decoration: none; }
    .dash-page .panel-footer a:hover { text-decoration: underline; }

    @media (max-width: 1100px) {
        .dash-page .kpi-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .dash-page .kpi:last-child:nth-child(odd) { grid-column: 1 / -1; }
        .dash-page .dash-grid { grid-template-columns: minmax(0, 1fr); }
        .dash-page .today-panel { grid-column: auto; }
    }

    @media (max-width: 760px) {
        .dash-page .today-item {
            grid-template-columns: 80px minmax(0, 1fr);
            gap: 12px;
        }
        .dash-page .today-mech,
        .dash-page .today-item .status { grid-column: 2; justify-self: start; }
    }

    @media (max-width: 650px) {
        .page-heading { align-items: stretch; }
        .dash-page .kpi-grid { grid-template-columns: minmax(0, 1fr); gap: 12px; }
        .dash-page .kpi { padding: 18px; }
        .dash-page .panel-header { padding: 17px; }
        .dash-page .summary-content { padding: 15px; }
        .dash-page .summary-item { padding: 13px; }
        .dash-page .today-list { padding: 14px; }
        .dash-page .today-more { padding: 0 14px 14px; }
        .dash-page .panel-footer { padding: 15px; }
        .dash-page .today-badge { white-space: normal; }
    }

    @media (prefers-reduced-motion: reduce) {
        .dash-page .kpi,
        .dash-page .summary-item,
        .dash-page .summary-link,
        .dash-page .today-item { transition: none; }
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
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
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
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
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
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
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
                <div class="panel-heading">
                    <div class="panel-heading-icon">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <rect x="3" y="4" width="18" height="17" rx="2"/><path d="M8 2v4M16 2v4M3 10h18"/>
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
                    <div class="summary-icon tone-blue">
                        <svg width="23" height="23" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
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
                        <svg width="23" height="23" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
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
                <div class="panel-heading">
                    <div class="panel-heading-icon">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
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
                    <div class="summary-icon tone-green">
                        <svg width="23" height="23" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
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
                        <svg width="23" height="23" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
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
                    <div class="panel-heading">
                        <div class="panel-heading-icon">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/>
                            </svg>
                        </div>
                        <div>
                            <div class="panel-title">Jadwal Servis Hari Ini</div>
                            <div class="panel-subtitle">Urut dari jam paling awal. Pesanan ditolak dan dibatalkan tidak ditampilkan.</div>
                        </div>
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

                            <div>
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