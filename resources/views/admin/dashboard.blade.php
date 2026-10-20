@extends('admin.layouts.app')

@section('title', 'Dashboard Admin')

@push('styles')
<style>
    /* Semua CSS di sini hanya berlaku untuk halaman dashboard (diawali .dash-page) */

    /* Kotak tanggal & jam di kanan judul */
    .clock-box {
        min-width: 240px;
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 16px;
        background: white;
        border: 1px solid var(--border);
        border-radius: 13px;
        box-shadow: 0 5px 14px #273d630b;
    }
    .clock-icon {
        width: 40px; height: 40px;
        display: grid; place-items: center; flex-shrink: 0;
        border-radius: 11px; background: #e7efff; color: var(--blue);
    }
    .clock-date { font-size: 13px; color: #46618e; margin-bottom: 4px; }
    .clock-time { font-size: 18px; font-weight: 800; font-variant-numeric: tabular-nums; }

    /* Tiga kartu ringkasan atas */
    .dash-page .kpi-grid { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 16px; margin-bottom: 20px; }
    .dash-page .kpi {
        display: flex; align-items: center; gap: 16px;
        padding: 20px;
        background: white;
        border: 1px solid #dae3ee;
        border-radius: 14px;
        box-shadow: 0 5px 14px #273d630b;
    }
    .dash-page .kpi-icon { width: 54px; height: 54px; display: grid; place-items: center; flex-shrink: 0; border-radius: 15px; }
    .dash-page .kpi-title { font-size: 14px; font-weight: 700; color: #526585; }
    .dash-page .kpi-number { margin-top: 6px; font-size: 30px; font-weight: 800; }
    .dash-page .kpi-desc { margin-top: 5px; font-size: 12px; color: var(--muted); }

    .dash-page .tone-blue { background: #e2eeff; color: #3580ff; }
    .dash-page .tone-orange { background: #fff1dc; color: #e99516; }
    .dash-page .tone-green { background: #def6ed; color: #19a875; }
    .dash-page .tone-red { background: #ffe7eb; color: #e54860; }

    /* Dua panel ringkasan + tabel aktivitas */
    .dash-page .dash-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 20px; align-items: start; }
    .dash-page .activity-panel { grid-column: 1 / -1; }
    .dash-page .panel { margin-bottom: 0; }

    .dash-page .panel-heading { display: flex; align-items: center; gap: 14px; }
    .dash-page .panel-heading-icon {
        width: 44px; height: 44px; display: grid; place-items: center; flex-shrink: 0;
        border-radius: 12px; background: linear-gradient(135deg, #3468d5, #355eb8); color: white;
    }

    .dash-page .summary-content { padding: 20px; }
    .dash-page .summary-item {
        display: flex; align-items: center; gap: 14px;
        padding: 16px;
        margin-bottom: 12px;
        border: 1px solid #e3eaf3;
        border-radius: 12px;
    }
    .dash-page .summary-icon { width: 48px; height: 48px; display: grid; place-items: center; flex-shrink: 0; border-radius: 13px; }
    .dash-page .summary-label { font-size: 14px; font-weight: 700; color: #526585; }
    .dash-page .summary-number { margin-top: 5px; font-size: 26px; font-weight: 800; }
    .dash-page .summary-desc { margin-top: 4px; font-size: 12px; color: #8190a8; }

    .dash-page .summary-link {
        display: flex; align-items: center; justify-content: space-between; gap: 10px;
        margin-top: 16px; padding: 13px 16px;
        border-radius: 10px; background: #f0f5ff; color: var(--blue);
        font-size: 13px; font-weight: 700;
        transition: background .2s ease;
    }
    .dash-page .summary-link:hover { background: #e2ebff; }

    /* Tabel aktivitas */
    .dash-page table { min-width: 560px; }
    .dash-page .customer-name { display: block; font-size: 14px; font-weight: 800; color: #17243f; }
    .dash-page .customer-detail { display: block; margin-top: 4px; font-size: 12px; color: #6f86ad; }

    .dash-page .status.waiting { background: #fff2d7; color: #b87400; }
    .dash-page .status.process { background: #e8f1ff; color: #2a5fd4; }
    .dash-page .status.done { background: #d6f5e5; color: #0f7a4d; }
    .dash-page .status.rejected { background: #ffe5e9; color: #c4253f; }

    .dash-page .table-footer { display: flex; justify-content: space-between; flex-wrap: wrap; gap: 10px; }
    .dash-page .table-footer a { color: var(--blue); font-weight: 700; }

    @media (max-width: 1100px) {
        .dash-page .kpi-grid { grid-template-columns: 1fr; gap: 12px; }
        .dash-page .dash-grid { grid-template-columns: minmax(0, 1fr); }
        .dash-page .activity-panel { grid-column: auto; }
    }
    @media (max-width: 650px) {
        .clock-box { width: 100%; min-width: 0; }
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

    $aktivitasTerbaru = $bookings->sortByDesc('created_at')->take(5);
@endphp

<section class="page-heading">
    <div>
        <div class="breadcrumb">Admin / Dashboard</div>
        <h1 class="page-title">Ringkasan Operasional Bengkel</h1>
        <p class="page-description">Pantau ringkasan booking, data mekanik, dan aktivitas bengkel dalam satu tempat.</p>
    </div>

    <div class="clock-box">
        <div class="clock-icon">
            <svg width="21" height="21" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect x="3" y="4" width="18" height="17" rx="2"/>
                <path d="M8 2v4M16 2v4M3 10h18"/>
            </svg>
        </div>
        <div>
            <div id="liveDate" class="clock-date">Memuat tanggal...</div>
            <div id="liveTime" class="clock-time">--:--:-- WIB</div>
        </div>
    </div>
</section>

<div class="dash-page">

    {{-- ============ KARTU RINGKASAN ============ --}}
    <section class="kpi-grid">
        <div class="kpi">
            <div class="kpi-icon tone-blue">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
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
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
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
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
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

        {{-- ============ RINGKASAN BOOKING ============ --}}
        <section class="panel">
            <div class="panel-header">
                <div class="panel-heading">
                    <div class="panel-heading-icon">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
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
                        <svg width="23" height="23" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
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
                        <svg width="23" height="23" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
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
                    Lihat Pengelolaan Pesanan <span>→</span>
                </a>
            </div>
        </section>

        {{-- ============ RINGKASAN MEKANIK ============ --}}
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
                    <div class="summary-icon tone-green">
                        <svg width="23" height="23" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
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
                        <svg width="23" height="23" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
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
                    Lihat Data Mekanik <span>→</span>
                </a>
            </div>
        </section>

        {{-- ============ AKTIVITAS BOOKING TERBARU ============ --}}
        <section class="panel activity-panel">
            <div class="panel-header">
                <div class="panel-heading">
                    <div class="panel-heading-icon">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="4" y="3" width="16" height="18" rx="2"/><path d="M8 7h8M8 11h8M8 15h5"/>
                        </svg>
                    </div>
                    <div>
                        <div class="panel-title">Aktivitas Booking Terbaru</div>
                        <div class="panel-subtitle">Lima booking terbaru. Tidak ada aksi pengelolaan di bagian ini.</div>
                    </div>
                </div>
            </div>

            <div class="table-wrapper">
                <table>
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
</div>
@endsection

@push('scripts')
<script>
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
@endpush