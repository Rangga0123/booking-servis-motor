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
        position: relative;
        overflow: hidden;
        margin-bottom: 30px;
        padding: 23px 25px;
        background: #fff;
        border: 1px solid #dce5f1;
        border-left: 4px solid #3264d8;
        border-radius: 10px;
        box-shadow: 0 3px 12px rgba(39, 61, 99, .035);
        animation: headingAppear .45s ease both;
    }

    .heading-text {
        min-width: 0;
        max-width: 850px;
    }

    .breadcrumb {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 9px;
        margin-bottom: 18px;
        color: #7182a3;
        font-size: 12px;
        line-height: 1.5;
    }

    .breadcrumb span:last-child {
        color: #3264d8;
        font-weight: 700;
    }

    .heading-greeting {
        display: inline-block;
        margin: 0 0 9px;
        color: #3264d8;
        font-size: 13px;
        font-weight: 700;
        line-height: 1.6;
    }

    .page-title {
        margin: 0;
        color: #14213d;
        font-size: 27px;
        font-weight: 800;
        line-height: 1.35;
        letter-spacing: -.45px;
        overflow-wrap: anywhere;
    }

    .page-description {
        max-width: 650px;
        margin: 9px 0 0;
        color: #7182a3;
        font-size: 13px;
        line-height: 1.8;
    }

    /* JUDUL INFORMASI BENGKEL */
    .workshop-section-heading {
        margin: 0 0 17px;
    }

    .workshop-section-heading h2 {
        margin: 0;
        color: #14213d;
        font-size: 21px;
        font-weight: 800;
        line-height: 1.5;
    }

    .workshop-section-heading p {
        max-width: 700px;
        margin: 5px 0 0;
        color: #7182a3;
        font-size: 13px;
        line-height: 1.8;
    }

    /* PANEL INFORMASI */
    .dashboard-info {
        overflow: hidden;
        background: #fff;
        border: 1px solid #dce5f1;
        border-radius: 12px;
        box-shadow: 0 3px 12px rgba(39, 61, 99, .035);
        animation: headingAppear .5s ease both;
    }

    /* DUA FOTO BENGKEL TANPA TEKS */
    .workshop-photo-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 18px;
        padding: 18px;
    }

    .workshop-photo-card {
        min-width: 0;
        overflow: hidden;
        background: #f0f4f9;
        border: 1px solid #e3eaf4;
        border-radius: 9px;
        transition: border-color .2s ease, box-shadow .2s ease;
    }

    .workshop-photo-card:hover {
        border-color: #c7d7f6;
        box-shadow: 0 5px 15px rgba(39, 61, 99, .07);
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
        transition: transform .35s ease;
    }

    .workshop-photo-card:hover .workshop-photo {
        transform: scale(1.025);
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

    /* DETAIL INFORMASI */
    .info-details {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        border-top: 1px solid #e8edf5;
        background: #fbfcff;
    }

    .info-detail {
        min-width: 0;
        padding: 20px;
    }

    .info-detail + .info-detail {
        border-left: 1px solid #e8edf5;
    }

    .info-detail-title {
        display: flex;
        align-items: center;
        gap: 9px;
        margin: 0 0 15px;
        color: #14213d;
        font-size: 14px;
        font-weight: 750;
        line-height: 1.6;
    }

    .info-detail-title svg {
        flex: 0 0 19px;
        width: 19px;
        height: 19px;
        color: #3568ce;
    }

    .dashboard-info-desc {
        color: #60708a;
        font-size: 13px;
        line-height: 1.9;
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
        color: #60708a;
        font-size: 13px;
        line-height: 1.8;
        overflow-wrap: anywhere;
    }

    .dashboard-info-list li:last-child {
        padding-bottom: 0;
        border-bottom: none;
    }

    .dashboard-info-list strong,
    .booking-step strong {
        color: #14213d;
        font-weight: 700;
    }

    /* STATUS OPERASIONAL */
    .operational-status {
        display: inline-flex;
        align-items: center;
        padding: 6px 10px;
        margin-bottom: 14px;
        border-radius: 5px;
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

    /* INFORMASI BOOKING */
    .booking-intro {
        margin: 0 0 16px;
        color: #60708a;
        font-size: 13px;
        line-height: 1.9;
    }

    .booking-steps {
        display: grid;
        gap: 15px;
        margin: 0;
        padding: 0;
        list-style: none;
    }

    .booking-step {
        display: flex;
        align-items: flex-start;
        gap: 11px;
        color: #60708a;
        font-size: 13px;
        line-height: 1.8;
    }

    .booking-step-number {
        display: flex;
        flex: 0 0 27px;
        width: 27px;
        height: 27px;
        align-items: center;
        justify-content: center;
        border-radius: 7px;
        background: #eaf0ff;
        color: #3264d8;
        font-size: 12px;
        font-weight: 800;
    }

    .booking-step-content {
        min-width: 0;
    }

    .booking-step-content strong {
        display: block;
        margin-bottom: 2px;
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
        color: #14213d;
        font-size: 13px;
        font-weight: 750;
        line-height: 1.7;
        overflow-wrap: anywhere;
    }

    .dashboard-announcement time {
        display: block;
        margin-bottom: 7px;
        color: #8491a8;
        font-size: 11px;
    }

    .dashboard-announcement p {
        margin: 0;
        color: #60708a;
        font-size: 13px;
        line-height: 1.8;
        overflow-wrap: anywhere;
        white-space: pre-line;
    }

    .dashboard-info-empty {
        margin: 0;
        color: #8995a9;
        font-size: 13px;
        line-height: 1.8;
    }

    /* ANIMASI RINGAN */
    @keyframes headingAppear {
        from {
            opacity: 0;
            transform: translateY(7px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* TABLET */
    @media (max-width: 1050px) {
        .info-details {
            grid-template-columns: 1fr;
        }

        .info-detail + .info-detail {
            border-top: 1px solid #e8edf5;
            border-left: none;
        }

        .info-detail {
            padding: 19px 20px;
        }
    }

    /* HP */
    @media (max-width: 700px) {
        .dashboard-content {
            padding-bottom: 22px;
        }

        .page-heading {
            padding: 18px;
            margin-bottom: 25px;
            border-radius: 9px;
        }

        .breadcrumb {
            gap: 7px;
            margin-bottom: 14px;
            font-size: 11px;
        }

        .heading-greeting {
            margin-bottom: 7px;
            font-size: 12px;
        }

        .page-title {
            font-size: 23px;
            line-height: 1.4;
        }

        .page-description {
            margin-top: 8px;
            font-size: 12px;
            line-height: 1.8;
        }

        .workshop-section-heading {
            margin-bottom: 13px;
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
            padding: 13px;
        }

        .info-detail {
            padding: 17px;
        }
    }

    @media (max-width: 380px) {
        .page-heading {
            padding: 15px;
        }

        .page-title {
            font-size: 21px;
        }

        .workshop-photo-grid {
            padding: 10px;
        }

        .info-detail {
            padding: 15px;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .page-heading,
        .dashboard-info {
            animation: none;
        }

        .workshop-photo,
        .workshop-photo-card {
            transition: none;
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
    @endphp

    {{-- HEADER DASHBOARD --}}
    <section class="page-heading">
        <div class="heading-text">

            <div class="breadcrumb">
                <span>Pelanggan</span>
                <span aria-hidden="true">/</span>
                <span>Dashboard</span>
            </div>

            <p class="heading-greeting">
                Selamat datang kembali, {{ $namaPelanggan }}!
            </p>

            <h1 class="page-title">Dashboard Pelanggan</h1>

            <p class="page-description">
                Lihat profil Bengkel Royal Motor, cek jam operasional,
                pelajari cara booking servis, dan baca pengumuman terbaru di sini.
            </p>

        </div>
    </section>

    {{-- JUDUL INFORMASI BENGKEL --}}
    <section class="workshop-section-heading">
        <h2>Informasi Bengkel</h2>
        <p>
            Kenali profil bengkel, lihat informasi layanan,
            cek jam operasional, dan dapatkan panduan booking servis.
        </p>
    </section>

    {{-- PANEL INFORMASI BENGKEL --}}
    <div class="dashboard-info">

        {{-- FOTO BENGKEL TANPA JUDUL DAN DESKRIPSI --}}
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
                                 stroke="currentColor" stroke-width="1.6"
                                 aria-hidden="true">
                                <rect x="3" y="3" width="18" height="18" rx="2"/>
                                <circle cx="8.5" cy="8.5" r="1.5"/>
                                <path d="m21 15-5-5L5 21"/>
                            </svg>
                            Foto profil bengkel belum ditambahkan.
                        </div>
                    @endif
                </div>
            </article>

            {{-- FOTO AKTIVITAS SERVIS --}}
            <article class="workshop-photo-card">
                <div class="workshop-photo-frame">
                    @if($fotoBengkel2)
                        <img
                            src="{{ asset($fotoBengkel2) }}"
                            alt="Aktivitas servis di {{ $namaBengkel }}"
                            class="workshop-photo"
                            loading="lazy"
                        >
                    @else
                        <div class="workshop-photo-placeholder">
                            <svg viewBox="0 0 24 24" fill="none"
                                 stroke="currentColor" stroke-width="1.6"
                                 aria-hidden="true">
                                <rect x="3" y="3" width="18" height="18" rx="2"/>
                                <circle cx="8.5" cy="8.5" r="1.5"/>
                                <path d="m21 15-5-5L5 21"/>
                            </svg>
                            Foto aktivitas servis belum ditambahkan.
                        </div>
                    @endif
                </div>
            </article>

        </div>

        {{-- JAM OPERASIONAL, INFORMASI BOOKING, DAN PENGUMUMAN --}}
        <div class="info-details">

            {{-- JAM OPERASIONAL --}}
            <section class="info-detail">
                <h3 class="info-detail-title">
                    <svg viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="1.8"
                         aria-hidden="true">
                        <circle cx="12" cy="12" r="9"/>
                        <path d="M12 7v5l3 2"/>
                    </svg>
                    Jam Operasional
                </h3>

                @if(strtolower($statusOperasional) === 'buka')
                    <span class="operational-status open">Sedang Buka</span>
                @elseif(strtolower($statusOperasional) === 'tutup')
                    <span class="operational-status closed">Sedang Tutup</span>
                @else
                    <span class="operational-status unknown">Belum Diatur</span>
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

            {{-- INFORMASI BOOKING --}}
            <section class="info-detail">
                <h3 class="info-detail-title">
                    <svg viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="1.8"
                         aria-hidden="true">
                        <rect x="3" y="5" width="18" height="16" rx="2"/>
                        <path d="M16 3v4M8 3v4M3 10h18"/>
                        <path d="m9 15 2 2 4-4"/>
                    </svg>
                    Informasi Booking
                </h3>

                <p class="booking-intro">
                    Dengan fitur booking servis online, Anda dapat memilih
                    layanan servis motor serta menentukan tanggal dan jam
                    kedatangan sesuai kebutuhan.

                    Buat booking terlebih dahulu agar jadwal servis lebih
                    teratur dan Anda dapat mempersiapkan kedatangan ke bengkel.
                </p>

                <ol class="booking-steps">
                    <li class="booking-step">
                        <span class="booking-step-number">1</span>
                        <div class="booking-step-content">
                            <strong>Pilih layanan servis</strong>
                            Tentukan layanan yang sesuai dengan kebutuhan motor Anda.
                        </div>
                    </li>

                    <li class="booking-step">
                        <span class="booking-step-number">2</span>
                        <div class="booking-step-content">
                            <strong>Tentukan jadwal kedatangan</strong>
                            Pilih tanggal dan jam yang diinginkan, lalu periksa
                            kembali data booking sebelum dikirim.
                        </div>
                    </li>

                    <li class="booking-step">
                        <span class="booking-step-number">3</span>
                        <div class="booking-step-content">
                            <strong>Pantau status booking</strong>
                            Buka menu Riwayat Booking untuk melihat perkembangan
                            status booking Anda.
                        </div>
                    </li>
                </ol>
            </section>

            {{-- PENGUMUMAN --}}
            <section class="info-detail">
                <h3 class="info-detail-title">
                    <svg viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="1.8"
                         aria-hidden="true">
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