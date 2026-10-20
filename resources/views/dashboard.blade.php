@extends('layouts.customer')

@section('title', 'Dashboard Pelanggan - Bengkel Royal Motor')

@push('styles')
<style>
    .dashboard-content {
        width: 100%;
        max-width: 1500px;
        margin: 0 auto;
        padding-bottom: 30px;
        color: #14213d;
        box-sizing: border-box;
    }

    .dashboard-content *,
    .dashboard-content *::before,
    .dashboard-content *::after {
        box-sizing: border-box;
    }

    /* HEADER DASHBOARD */
    .page-heading {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        flex-wrap: wrap;
        margin-bottom: 30px;
    }

    .heading-text {
        flex: 1;
        min-width: 0;
    }

    .breadcrumb {
        margin-bottom: 10px;
        font-size: 12px;
        color: #7182a3;
    }

    .page-title {
        margin: 0;
        font-size: 28px;
        font-weight: 800;
        color: #14213d;
        line-height: 1.4;
        letter-spacing: -.4px;
    }

    .page-description {
        max-width: 620px;
        margin: 9px 0 0;
        font-size: 14px;
        line-height: 1.8;
        color: #7182a3;
    }

    .page-description strong {
        color: #244fae;
        font-weight: 750;
    }

    /* JAM DIGITAL */
    .clock-box {
        min-width: 245px;
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 13px 16px;
        background: #fff;
        border: 1px solid #dce5f1;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(39, 61, 99, .04);
    }

    .clock-icon {
        width: 42px;
        height: 42px;
        display: grid;
        place-items: center;
        flex-shrink: 0;
        border-radius: 10px;
        background: #e7efff;
        color: #3264d8;
    }

    .clock-date {
        margin-bottom: 4px;
        font-size: 12px;
        color: #7182a3;
        line-height: 1.5;
    }

    .clock-time {
        font-size: 18px;
        font-weight: 800;
        color: #14213d;
        font-variant-numeric: tabular-nums;
    }

    /* JUDUL INFORMASI BENGKEL */
    .workshop-section-heading {
        margin: 0 0 17px;
    }

    .workshop-section-heading h2 {
        margin: 0;
        font-size: 21px;
        font-weight: 800;
        line-height: 1.5;
        color: #14213d;
    }

    .workshop-section-heading p {
        max-width: 700px;
        margin: 5px 0 0;
        font-size: 13px;
        line-height: 1.8;
        color: #7182a3;
    }

    /* PANEL INFORMASI BENGKEL */
    .dashboard-info {
        overflow: hidden;
        background: #fff;
        border: 1px solid #dce5f1;
        border-radius: 13px;
        box-shadow: 0 4px 14px rgba(39, 61, 99, .04);
    }

    /* FOTO BENGKEL */
    .workshop-photo-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 20px;
        padding: 20px;
    }

    .workshop-photo-card {
        min-width: 0;
        overflow: hidden;
        border: 1px solid #e3eaf4;
        border-radius: 10px;
        background: #fff;
    }

    .workshop-photo-frame {
        width: 100%;
        aspect-ratio: 16 / 9;
        overflow: hidden;
        background: #f0f4f9;
    }

    .workshop-photo {
        display: block;
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
    }

    .workshop-photo-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        gap: 8px;
        padding: 15px;
        color: #8190a8;
        font-size: 13px;
        line-height: 1.7;
        text-align: center;
    }

    .workshop-photo-placeholder svg {
        width: 30px;
        height: 30px;
        opacity: .7;
    }

    .workshop-photo-content {
        padding: 16px 18px 18px;
    }

    .workshop-photo-title {
        margin: 0 0 8px;
        font-size: 16px;
        font-weight: 750;
        line-height: 1.5;
        color: #14213d;
        overflow-wrap: anywhere;
    }

    .workshop-photo-description {
        font-size: 13px;
        line-height: 1.9;
        color: #60708a;
        overflow-wrap: anywhere;
        white-space: pre-line;
    }

    /* DETAIL INFORMASI */
    .info-details {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        border-top: 1px solid #e8edf5;
        background: #fbfcff;
    }

    .info-detail {
        min-width: 0;
        padding: 21px;
    }

    .info-detail + .info-detail {
        border-left: 1px solid #e8edf5;
    }

    .info-detail-title {
        display: flex;
        align-items: center;
        gap: 9px;
        margin: 0 0 15px;
        font-size: 15px;
        font-weight: 750;
        line-height: 1.5;
        color: #14213d;
    }

    .info-detail-title svg {
        flex: 0 0 20px;
        width: 20px;
        height: 20px;
        color: #3568ce;
    }

    .dashboard-info-desc {
        font-size: 13px;
        line-height: 1.9;
        color: #60708a;
        overflow-wrap: anywhere;
        white-space: pre-line;
    }

    .dashboard-info-list {
        display: grid;
        gap: 12px;
        margin: 0;
        padding: 0;
        list-style: none;
    }

    .dashboard-info-list li {
        padding-bottom: 12px;
        border-bottom: 1px solid #edf1f7;
        font-size: 13px;
        line-height: 1.8;
        color: #60708a;
        overflow-wrap: anywhere;
    }

    .dashboard-info-list li:last-child {
        padding-bottom: 0;
        border-bottom: none;
    }

    .dashboard-info-list strong {
        color: #14213d;
        font-weight: 700;
    }

    /* STATUS OPERASIONAL */
    .operational-status {
        display: inline-flex;
        align-items: center;
        padding: 6px 10px;
        margin-bottom: 14px;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 750;
    }

    .operational-status.open {
        color: #0f7a4d;
        background: #e4f7ec;
    }

    .operational-status.closed {
        color: #c4253f;
        background: #ffe9ec;
    }

    .operational-status.unknown {
        color: #946200;
        background: #fff2d7;
    }

    /* PENGUMUMAN */
    .dashboard-announcement {
        padding: 13px 0;
        border-bottom: 1px solid #edf1f7;
    }

    .dashboard-announcement:first-child {
        padding-top: 0;
    }

    .dashboard-announcement:last-child {
        padding-bottom: 0;
        border-bottom: none;
    }

    .dashboard-announcement h4 {
        margin: 0 0 5px;
        font-size: 13px;
        font-weight: 750;
        line-height: 1.7;
        color: #14213d;
        overflow-wrap: anywhere;
    }

    .dashboard-announcement time {
        display: block;
        margin-bottom: 7px;
        font-size: 11px;
        color: #8491a8;
    }

    .dashboard-announcement p {
        margin: 0;
        font-size: 13px;
        line-height: 1.8;
        color: #60708a;
        overflow-wrap: anywhere;
        white-space: pre-line;
    }

    .dashboard-info-empty {
        margin: 0;
        font-size: 13px;
        line-height: 1.8;
        color: #8995a9;
    }

    /* RESPONSIVE TABLET */
    @media (max-width: 1050px) {
        .info-details {
            grid-template-columns: 1fr;
        }

        .info-detail + .info-detail {
            border-left: none;
            border-top: 1px solid #e8edf5;
        }

        .info-detail {
            padding: 19px 20px;
        }
    }

    /* RESPONSIVE HP */
    @media (max-width: 700px) {
        .dashboard-content {
            padding-bottom: 22px;
        }

        .page-heading {
            align-items: stretch;
            gap: 16px;
            margin-bottom: 25px;
        }

        .heading-text {
            flex: 1 1 100%;
        }

        .breadcrumb {
            margin-bottom: 8px;
        }

        .page-title {
            font-size: 24px;
            line-height: 1.4;
        }

        .page-description {
            margin-top: 8px;
            font-size: 13px;
            line-height: 1.8;
        }

        .clock-box {
            width: 100%;
            min-width: 0;
            padding: 12px 14px;
        }

        .clock-date {
            font-size: 12px;
        }

        .clock-time {
            font-size: 17px;
        }

        .workshop-section-heading {
            margin-bottom: 14px;
        }

        .workshop-section-heading h2 {
            font-size: 19px;
        }

        .workshop-section-heading p {
            font-size: 12px;
        }

        .workshop-photo-grid {
            grid-template-columns: 1fr;
            gap: 14px;
            padding: 14px;
        }

        .workshop-photo-content {
            padding: 14px 15px 16px;
        }

        .workshop-photo-title {
            font-size: 15px;
        }

        .workshop-photo-description {
            font-size: 13px;
        }

        .info-detail {
            padding: 17px;
        }
    }

    @media (max-width: 380px) {
        .page-title {
            font-size: 22px;
        }

        .clock-icon {
            width: 38px;
            height: 38px;
        }

        .clock-time {
            font-size: 16px;
        }

        .workshop-photo-grid {
            padding: 10px;
        }
    }
</style>
@endpush

@section('content')

<div class="dashboard-content">

    @php
        $bookings = $bookings ?? collect();

        $totalBooking = $bookings->count();

        $totalProses = $bookings->filter(function ($booking) {
            return in_array(strtolower($booking->status ?? ''), [
                'proses',
                'diproses',
                'sedang dikerjakan',
                'dikerjakan',
                'disetujui',
                'diterima'
            ]);
        })->count();

        $totalSelesai = $bookings->filter(function ($booking) {
            return strtolower($booking->status ?? '') === 'selesai';
        })->count();

        $namaPelanggan = auth()->user()->name ?? 'Pelanggan';

        $informasiBengkel = $informasiBengkel ?? null;

        $namaBengkel = $informasiBengkel?->nama_bengkel
            ?? 'Bengkel Royal Motor';

        $jamOperasional = $jamOperasional
            ?? (($informasiBengkel?->jam_buka && $informasiBengkel?->jam_tutup)
                ? $informasiBengkel->jam_buka . ' - ' . $informasiBengkel->jam_tutup . ' WIB'
                : '13.00 - 22.00 WIB');

        $statusOperasional = $statusOperasional
            ?? $informasiBengkel?->status_operasional
            ?? 'belum diatur';

        $hariOperasional = trim(
            (string) ($informasiBengkel?->hari_operasional ?? ''),
            " ,"
        );

        if ($hariOperasional === '') {
            $hariOperasional = 'Senin–Minggu';
        }

        $pengumuman = $pengumuman ?? collect();

        $fotoBengkel1 = $informasiBengkel?->foto_1;
        $fotoBengkel2 = $informasiBengkel?->foto_2;

        $deskripsiFoto1 = $informasiBengkel?->deskripsi_foto_1;
        $deskripsiFoto2 = $informasiBengkel?->deskripsi_foto_2;
    @endphp

    {{-- HEADER DASHBOARD --}}
    <section class="page-heading">
        <div class="heading-text">
            <div class="breadcrumb">Pelanggan / Dashboard</div>

            <h1 class="page-title">Dashboard Pelanggan</h1>

            <p class="page-description">
                Selamat datang kembali,
                <strong>{{ $namaPelanggan }}</strong>!
                Pantau booking servis dan lihat informasi terbaru
                dari Bengkel Royal Motor di sini.
            </p>
        </div>

        <div class="clock-box">
            <div class="clock-icon">
                <svg width="21" height="21" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="4" width="18" height="17" rx="2"/>
                    <path d="M8 2v4M16 2v4M3 10h18"/>
                </svg>
            </div>

            <div>
                <div id="liveDate" class="clock-date">
                    Memuat tanggal...
                </div>

                <div id="liveTime" class="clock-time">
                    --:--:-- WIB
                </div>
            </div>
        </div>
    </section>

    {{-- JUDUL INFORMASI BENGKEL --}}
    <section class="workshop-section-heading">
        <h2>Informasi Bengkel</h2>
        <p>
            Kenali profil bengkel, layanan yang tersedia,
            jam operasional, dan pengumuman terbaru.
        </p>
    </section>

    {{-- PANEL INFORMASI BENGKEL --}}
    <div class="dashboard-info">

        {{-- FOTO PROFIL DAN LAYANAN --}}
        <div class="workshop-photo-grid">

            {{-- FOTO PROFIL BENGKEL --}}
            <article class="workshop-photo-card">
                <div class="workshop-photo-frame">
                    @if($fotoBengkel1)
                        <img
                            src="{{ asset($fotoBengkel1) }}"
                            alt="Foto {{ $namaBengkel }}"
                            class="workshop-photo"
                            loading="lazy"
                        >
                    @else
                        <div class="workshop-photo-placeholder">
                            <svg viewBox="0 0 24 24" fill="none"
                                 stroke="currentColor" stroke-width="1.6">
                                <rect x="3" y="3" width="18" height="18" rx="2"/>
                                <circle cx="8.5" cy="8.5" r="1.5"/>
                                <path d="m21 15-5-5L5 21"/>
                            </svg>
                            Foto profil bengkel belum ditambahkan.
                        </div>
                    @endif
                </div>

                <div class="workshop-photo-content">
                    <h3 class="workshop-photo-title">Profil Bengkel</h3>

                    <div class="workshop-photo-description">
                        {{ $deskripsiFoto1 ?: ($informasiBengkel?->deskripsi
                            ?: 'Informasi profil Bengkel Royal Motor belum ditambahkan.') }}
                    </div>
                </div>
            </article>

            {{-- FOTO INFORMASI LAYANAN --}}
            <article class="workshop-photo-card">
                <div class="workshop-photo-frame">
                    @if($fotoBengkel2)
                        <img
                            src="{{ asset($fotoBengkel2) }}"
                            alt="Informasi layanan {{ $namaBengkel }}"
                            class="workshop-photo"
                            loading="lazy"
                        >
                    @else
                        <div class="workshop-photo-placeholder">
                            <svg viewBox="0 0 24 24" fill="none"
                                 stroke="currentColor" stroke-width="1.6">
                                <rect x="3" y="3" width="18" height="18" rx="2"/>
                                <circle cx="8.5" cy="8.5" r="1.5"/>
                                <path d="m21 15-5-5L5 21"/>
                            </svg>
                            Foto layanan belum ditambahkan.
                        </div>
                    @endif
                </div>

                <div class="workshop-photo-content">
                    <h3 class="workshop-photo-title">Informasi Layanan</h3>

                    <div class="workshop-photo-description">
                        {{ $deskripsiFoto2 ?: ($informasiBengkel?->informasi_layanan
                            ?: 'Informasi layanan bengkel belum ditambahkan.') }}
                    </div>
                </div>
            </article>

        </div>

        {{-- JAM OPERASIONAL, LAYANAN, PENGUMUMAN --}}
        <div class="info-details">

            {{-- JAM OPERASIONAL --}}
            <section class="info-detail">
                <h3 class="info-detail-title">
                    <svg viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="1.8">
                        <circle cx="12" cy="12" r="9"/>
                        <path d="M12 7v5l3 2"/>
                    </svg>
                    Jam Operasional
                </h3>

                @if(strtolower($statusOperasional) === 'buka')
                    <span class="operational-status open">
                        Sedang Buka
                    </span>
                @elseif(strtolower($statusOperasional) === 'tutup')
                    <span class="operational-status closed">
                        Sedang Tutup
                    </span>
                @else
                    <span class="operational-status unknown">
                        Belum Diatur
                    </span>
                @endif

                <ul class="dashboard-info-list">
                    <li>
                        <strong>Hari operasional</strong><br>
                        {{ $hariOperasional }}
                    </li>

                    <li>
                        <strong>Jam pelayanan</strong><br>
                        {{ $jamOperasional }}
                    </li>
                </ul>
            </section>

            {{-- INFORMASI LAYANAN --}}
            <section class="info-detail">
                <h3 class="info-detail-title">
                    <svg viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="1.8">
                        <path d="m14.7 6.3 3 3M4 20l5.5-1.2L20 8.3 15.7 4 5.2 14.5 4 20Z"/>
                        <path d="m13.8 5.9 4.3 4.3"/>
                    </svg>
                    Informasi Layanan
                </h3>

                <div class="dashboard-info-desc">
                    {{ $informasiBengkel?->informasi_layanan
                        ?: 'Informasi layanan bengkel belum ditambahkan oleh admin.' }}
                </div>
            </section>

            {{-- PENGUMUMAN --}}
            <section class="info-detail">
                <h3 class="info-detail-title">
                    <svg viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="1.8">
                        <path d="M18 8a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9"/>
                        <path d="M10 21h4"/>
                    </svg>
                    Pengumuman Terbaru
                </h3>

                @forelse($pengumuman as $item)
                    <article class="dashboard-announcement">
                        <h4>{{ $item->judul }}</h4>

                        <time>
                            {{ $item->created_at?->format('d M Y') ?? '' }}
                        </time>

                        <p>{{ $item->isi }}</p>
                    </article>
                @empty
                    <p class="dashboard-info-empty">
                        Belum ada pengumuman dari bengkel.
                    </p>
                @endforelse
            </section>

        </div>
    </div>

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