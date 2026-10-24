@extends('layouts.customer')

@section('title', 'Riwayat Booking - Bengkel Royal Motor')

@push('styles')
<style>
    .rb-page,
    .rb-page * {
        box-sizing: border-box;
    }

    .rb-page {
        width: 100%;
        max-width: 1450px;
        margin: 0 auto;
        padding: 0 0 30px;
        color: #14213d;
    }

    /* HEADER HALAMAN */
    .rb-head {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 22px;
        margin-bottom: 25px;
        padding: 23px 25px;
        overflow: hidden;
        background: linear-gradient(120deg, #ffffff 0%, #f7faff 100%);
        border: 1px solid #dce5f1;
        border-left: 4px solid #3264d8;
        border-radius: 14px;
        box-shadow: 0 4px 14px rgba(39, 61, 99, .04);
    }

    .rb-head::after {
        content: "";
        position: absolute;
        top: -65px;
        right: -35px;
        width: 170px;
        height: 170px;
        border-radius: 50%;
        background: rgba(50, 100, 216, .045);
        pointer-events: none;
    }

    .rb-head-text {
        position: relative;
        z-index: 1;
        min-width: 0;
    }

    .rb-crumb {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 8px;
        margin-bottom: 12px;
        color: #7182a3;
        font-size: 12px;
        font-weight: 500;
    }

    .rb-crumb span:last-child {
        color: #3264d8;
        font-weight: 700;
    }

    .rb-heading-label {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        margin-bottom: 8px;
        color: #3264d8;
        font-size: 11px;
        font-weight: 800;
        letter-spacing: 1px;
        text-transform: uppercase;
    }

    .rb-heading-label::before {
        content: "";
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: #3264d8;
    }

    .rb-title {
        margin: 0;
        color: #14213d;
        font-size: 27px;
        font-weight: 800;
        line-height: 1.35;
        letter-spacing: -.5px;
        overflow-wrap: anywhere;
    }

    .rb-desc {
        max-width: 650px;
        margin: 8px 0 0;
        color: #7182a3;
        font-size: 13px;
        line-height: 1.8;
    }

    /* TOMBOL */
    .rb-btn {
        position: relative;
        z-index: 1;
        display: inline-flex;
        flex-shrink: 0;
        align-items: center;
        justify-content: center;
        gap: 9px;
        min-height: 43px;
        padding: 11px 16px;
        border: 1px solid transparent;
        border-radius: 9px;
        font-size: 12px;
        font-weight: 750;
        text-decoration: none;
        cursor: pointer;
        transition: background .2s ease, transform .2s ease,
                    box-shadow .2s ease;
    }

    .rb-btn:hover {
        transform: translateY(-2px);
    }

    .rb-btn-primary {
        color: #fff;
        background: #3264d8;
        box-shadow: 0 5px 13px rgba(50, 100, 216, .18);
    }

    .rb-btn-primary:hover {
        color: #fff;
        background: #244fb5;
        box-shadow: 0 7px 16px rgba(50, 100, 216, .23);
    }

    /* PESAN */
    .rb-alert {
        padding: 14px 16px;
        margin-bottom: 18px;
        border-radius: 10px;
        font-size: 13px;
        line-height: 1.7;
        overflow-wrap: anywhere;
    }

    .rb-alert.success {
        color: #137849;
        background: #e8f8ef;
        border: 1px solid #bcebd0;
    }

    .rb-alert.error {
        color: #bd263e;
        background: #fff0f2;
        border: 1px solid #ffd1d8;
    }

    .rb-alert ul {
        margin: 7px 0 0;
        padding-left: 20px;
    }

    /* STATISTIK */
    .rb-stats {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 17px;
        margin-bottom: 24px;
    }

    .rb-stat {
        position: relative;
        min-width: 0;
        overflow: hidden;
        padding: 21px;
        background: #fff;
        border: 1px solid #dce5f1;
        border-top: 3px solid #64748b;
        border-radius: 13px;
        box-shadow: 0 4px 13px rgba(39, 61, 99, .04);
        transition: transform .2s ease, box-shadow .2s ease;
    }

    .rb-stat:nth-child(2) {
        border-top-color: #3264d8;
    }

    .rb-stat:nth-child(3) {
        border-top-color: #0f9660;
    }

    .rb-stat:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(39, 61, 99, .08);
    }

    .rb-stat-label {
        padding-right: 48px;
        color: #60708a;
        font-size: 12px;
        font-weight: 700;
        line-height: 1.6;
    }

    .rb-stat-number {
        margin-top: 12px;
        color: #14213d;
        font-size: 32px;
        font-weight: 800;
        line-height: 1.2;
        letter-spacing: -.5px;
        font-variant-numeric: tabular-nums;
    }

    .rb-stat-number.blue {
        color: #3264d8;
    }

    .rb-stat-number.green {
        color: #0f9660;
    }

    .rb-stat-desc {
        margin-top: 8px;
        color: #8491a8;
        font-size: 11px;
        line-height: 1.7;
    }

    .rb-stat-icon {
        position: absolute;
        top: 18px;
        right: 18px;
        display: grid;
        place-items: center;
        width: 39px;
        height: 39px;
        border-radius: 10px;
        background: #edf1f7;
        color: #52647b;
        font-size: 19px;
        font-weight: 800;
    }

    .rb-stat:nth-child(2) .rb-stat-icon {
        color: #3264d8;
        background: #e7efff;
    }

    .rb-stat:nth-child(3) .rb-stat-icon {
        color: #0f9660;
        background: #e1f8eb;
    }

    /* PANEL RIWAYAT */
    .rb-panel {
        min-width: 0;
        overflow: hidden;
        background: #fff;
        border: 1px solid #dce5f1;
        border-radius: 13px;
        box-shadow: 0 4px 15px rgba(39, 61, 99, .045);
    }

    .rb-panel-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
        padding: 20px 22px;
        background: #fff;
        border-bottom: 1px solid #e8edf5;
    }

    .rb-panel-heading {
        min-width: 0;
    }

    .rb-panel-title {
        margin: 0;
        color: #14213d;
        font-size: 17px;
        font-weight: 800;
        line-height: 1.5;
    }

    .rb-panel-sub {
        margin-top: 5px;
        color: #7182a3;
        font-size: 12px;
        line-height: 1.7;
    }

    .rb-panel-tag {
        display: inline-flex;
        flex-shrink: 0;
        align-items: center;
        gap: 6px;
        padding: 7px 10px;
        color: #3264d8;
        background: #edf3ff;
        border: 1px solid #dce7ff;
        border-radius: 7px;
        font-size: 11px;
        font-weight: 750;
    }

    /* TABEL DESKTOP */
    .rb-table-wrap {
        width: 100%;
        overflow-x: auto;
    }

    .rb-table {
        width: 100%;
        min-width: 850px;
        border-collapse: collapse;
        border-spacing: 0;
        text-align: left;
        background: #fff;
    }

    .rb-table thead {
        background: #f5f8fd;
    }

    .rb-table th {
        padding: 15px 16px;
        color: #60708a;
        background: #f5f8fd;
        border-bottom: 1px solid #e2e9f3;
        font-size: 11px;
        font-weight: 800;
        letter-spacing: .35px;
        white-space: nowrap;
        text-transform: uppercase;
    }

    .rb-table td {
        padding: 16px;
        color: #52647b;
        border-bottom: 1px solid #edf1f7;
        font-size: 12px;
        line-height: 1.7;
        vertical-align: middle;
    }

    .rb-table tbody tr:last-child td {
        border-bottom: none;
    }

    .rb-table tbody tr {
        transition: background .18s ease;
    }

    .rb-table tbody tr:nth-child(even) {
        background: #fbfcff;
    }

    .rb-table tbody tr:hover {
        background: #f2f6ff;
    }

    .rb-strong {
        color: #14213d;
        font-size: 13px;
        font-weight: 750;
        line-height: 1.6;
        overflow-wrap: anywhere;
    }

    .rb-small {
        margin-top: 4px;
        color: #8491a8;
        font-size: 11px;
        line-height: 1.6;
        overflow-wrap: anywhere;
    }

    /* STATUS */
    .rb-status {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 6px 9px;
        border: 1px solid transparent;
        border-radius: 7px;
        font-size: 10px;
        font-weight: 800;
        line-height: 1.5;
        white-space: nowrap;
    }

    .rb-status.selesai {
        color: #087647;
        background: #e1f8eb;
        border-color: #bcebd0;
    }

    .rb-status.proses {
        color: #2457bd;
        background: #e7efff;
        border-color: #cbdcff;
    }

    .rb-status.ditolak {
        color: #bb2942;
        background: #ffedf0;
        border-color: #ffd0d8;
    }

    .rb-status.menunggu {
        color: #956000;
        background: #fff5dc;
        border-color: #ffe3a0;
    }

    /* AKSI */
    .rb-actions {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: center;
        gap: 6px;
    }

    .rb-actions form {
        display: inline-flex;
        margin: 0;
    }

    .rb-link {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 32px;
        padding: 7px 10px;
        border: 1px solid transparent;
        border-radius: 7px;
        font-family: inherit;
        font-size: 10px;
        font-weight: 800;
        line-height: 1.4;
        text-decoration: none;
        white-space: nowrap;
        cursor: pointer;
        transition: background .2s ease, transform .2s ease;
    }

    .rb-link:hover {
        transform: translateY(-1px);
    }

    .rb-link.detail {
        color: #1854b4;
        background: #eaf2ff;
        border-color: #d2e2ff;
    }

    .rb-link.detail:hover {
        background: #d8e7ff;
    }

    .rb-link.edit {
        color: #8a5800;
        background: #fff4d9;
        border-color: #ffe3a0;
    }

    .rb-link.edit:hover {
        background: #ffe9b6;
    }

    .rb-link.cancel {
        color: #bd2942;
        background: #fff0f2;
        border-color: #ffd1d8;
    }

    .rb-link.cancel:hover {
        background: #ffdde3;
    }

    /* KOSONG */
    .rb-empty {
        padding: 48px 20px;
        text-align: center;
    }

    .rb-empty-icon {
        display: grid;
        place-items: center;
        width: 55px;
        height: 55px;
        margin: 0 auto 16px;
        color: #3264d8;
        background: #edf3ff;
        border: 1px solid #dce7ff;
        border-radius: 15px;
        font-size: 25px;
        font-weight: 700;
    }

    .rb-empty h3 {
        margin: 0;
        color: #14213d;
        font-size: 17px;
        font-weight: 800;
    }

    .rb-empty p {
        max-width: 420px;
        margin: 9px auto 19px;
        color: #7182a3;
        font-size: 13px;
        line-height: 1.8;
    }

    /* KARTU HP */
    .rb-mobile {
        display: none;
        padding: 14px;
    }

    .rb-card {
        padding: 15px;
        margin-bottom: 12px;
        background: #fff;
        border: 1px solid #dce5f1;
        border-left: 3px solid #3264d8;
        border-radius: 11px;
        box-shadow: 0 3px 10px rgba(39, 61, 99, .035);
    }

    .rb-card:last-child {
        margin-bottom: 0;
    }

    .rb-card-top {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 10px;
    }

    .rb-card-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 13px;
        margin-top: 14px;
        padding-top: 14px;
        border-top: 1px solid #e8edf5;
    }

    .rb-card-grid .full {
        grid-column: 1 / -1;
    }

    .rb-card-label {
        color: #8491a8;
        font-size: 11px;
        line-height: 1.5;
    }

    .rb-card-value {
        margin-top: 5px;
        color: #263752;
        font-size: 12px;
        font-weight: 700;
        line-height: 1.7;
        overflow-wrap: anywhere;
    }

    .rb-card .rb-actions {
        justify-content: flex-start;
        margin-top: 14px;
        padding-top: 13px;
        border-top: 1px solid #e8edf5;
    }

    .rb-foot {
        margin-top: 20px;
        color: #94a0b2;
        font-size: 11px;
        line-height: 1.7;
        text-align: center;
    }

    /* TABLET */
    @media (max-width: 1050px) {
        .rb-page {
            max-width: 100%;
        }

        .rb-stats {
            gap: 12px;
        }

        .rb-stat {
            padding: 18px;
        }

        .rb-table th,
        .rb-table td {
            padding: 13px 11px;
        }
    }

    /* HP DAN TABLET KECIL */
    @media (max-width: 800px) {
        .rb-head {
            align-items: flex-start;
            padding: 19px;
        }

        .rb-title {
            font-size: 24px;
        }

        .rb-stats {
            grid-template-columns: 1fr;
            gap: 12px;
        }

        .rb-stat {
            padding: 18px;
        }

        .rb-stat-number {
            margin-top: 9px;
            font-size: 28px;
        }

        .rb-stat-icon {
            top: 15px;
            right: 16px;
        }

        .rb-table-wrap {
            display: none;
        }

        .rb-mobile {
            display: block;
        }

        .rb-panel-head {
            padding: 17px;
        }
    }

    @media (max-width: 560px) {
        .rb-page {
            padding-bottom: 22px;
        }

        .rb-head {
            display: block;
            margin-bottom: 19px;
            padding: 17px;
        }

        .rb-crumb {
            margin-bottom: 10px;
        }

        .rb-heading-label {
            font-size: 10px;
        }

        .rb-title {
            font-size: 22px;
            line-height: 1.4;
        }

        .rb-desc {
            margin-top: 7px;
            font-size: 12px;
            line-height: 1.8;
        }

        .rb-head .rb-btn {
            width: 100%;
            margin-top: 16px;
        }

        .rb-stat-label {
            font-size: 12px;
        }

        .rb-panel-head {
            align-items: flex-start;
            padding: 15px;
        }

        .rb-panel-title {
            font-size: 15px;
        }

        .rb-panel-sub {
            font-size: 11px;
        }

        .rb-panel-tag {
            display: none;
        }

        .rb-mobile {
            padding: 10px;
        }

        .rb-card {
            padding: 13px;
        }

        .rb-card-top {
            flex-wrap: wrap;
        }

        .rb-card .rb-actions {
            gap: 7px;
        }

        .rb-link {
            min-height: 34px;
            padding: 8px 10px;
        }

        .rb-empty {
            padding: 35px 17px;
        }
    }

    @media (max-width: 360px) {
        .rb-title {
            font-size: 20px;
        }

        .rb-card-grid {
            gap: 10px;
        }

        .rb-card-top {
            flex-direction: column;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .rb-stat,
        .rb-btn,
        .rb-link {
            transition: none;
        }
    }
</style>
@endpush

@section('content')
<div class="rb-page">

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
                'diterima',
            ]);
        })->count();

        $totalSelesai = $bookings->filter(function ($booking) {
            return strtolower($booking->status ?? '') === 'selesai';
        })->count();
    @endphp

    {{-- HEADER RIWAYAT --}}
    <section class="rb-head">
        <div class="rb-head-text">
            <div class="rb-crumb">
                <span>Pelanggan</span>
                <span aria-hidden="true">/</span>
                <span>Riwayat Booking</span>
            </div>

            <div class="rb-heading-label">Area Pelanggan</div>

            <h1 class="rb-title">Riwayat Booking</h1>

            <p class="rb-desc">
                Pantau jadwal servis, status pesanan, dan informasi kendaraan
                yang sudah kamu daftarkan di Bengkel Royal Motor.
            </p>
        </div>

        <a href="{{ route('booking.create') }}" class="rb-btn rb-btn-primary">
            <span aria-hidden="true">＋</span>
            Booking Baru
        </a>
    </section>

    {{-- NOTIFIKASI --}}
    @if (session('success'))
        <div class="rb-alert success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="rb-alert error">
            {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="rb-alert error">
            <strong>Terjadi kesalahan:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- STATISTIK BOOKING --}}
    <section class="rb-stats">
        <article class="rb-stat">
            <div class="rb-stat-icon" aria-hidden="true">#</div>
            <div class="rb-stat-label">Total Booking</div>
            <div class="rb-stat-number">{{ $totalBooking }}</div>
            <div class="rb-stat-desc">Semua pesanan milik kamu</div>
        </article>

        <article class="rb-stat">
            <div class="rb-stat-icon" aria-hidden="true">↻</div>
            <div class="rb-stat-label">Sedang Diproses</div>
            <div class="rb-stat-number blue">{{ $totalProses }}</div>
            <div class="rb-stat-desc">Pesanan yang sedang ditangani</div>
        </article>

        <article class="rb-stat">
            <div class="rb-stat-icon" aria-hidden="true">✓</div>
            <div class="rb-stat-label">Servis Selesai</div>
            <div class="rb-stat-number green">{{ $totalSelesai }}</div>
            <div class="rb-stat-desc">Pesanan yang telah selesai</div>
        </article>
    </section>

    {{-- PANEL RIWAYAT --}}
    <section class="rb-panel">
        <div class="rb-panel-head">
            <div class="rb-panel-heading">
                <h2 class="rb-panel-title">Riwayat Booking Saya</h2>
                <div class="rb-panel-sub">
                    Detail kendaraan, jadwal, mekanik, status, dan tindakan booking.
                </div>
            </div>

            <span class="rb-panel-tag">
                {{ $totalBooking }} Pesanan
            </span>
        </div>

        @if ($bookings->isEmpty())
            <div class="rb-empty">
                <div class="rb-empty-icon" aria-hidden="true">▤</div>

                <h3>Belum Ada Booking</h3>

                <p>
                    Kamu belum memiliki riwayat booking servis.
                    Buat booking baru untuk memilih jadwal servis motor.
                </p>

                <a href="{{ route('booking.create') }}" class="rb-btn rb-btn-primary">
                    <span aria-hidden="true">＋</span>
                    Booking Sekarang
                </a>
            </div>
        @else

            {{-- TABEL DESKTOP --}}
            <div class="rb-table-wrap">
                <table class="rb-table">
                    <thead>
                        <tr>
                            <th>Kendaraan</th>
                            <th>Jenis Servis</th>
                            <th>Jadwal</th>
                            <th>Mekanik</th>
                            <th>Status</th>
                            <th style="text-align: center;">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($bookings as $booking)
                            @php
                                $status = strtolower($booking->status ?? 'menunggu');

                                $statusClass = match ($status) {
                                    'selesai' => 'selesai',
                                    'ditolak', 'dibatalkan' => 'ditolak',
                                    'proses', 'diproses', 'sedang dikerjakan',
                                    'dikerjakan', 'disetujui', 'diterima' => 'proses',
                                    default => 'menunggu',
                                };

                                $bisaUbah = in_array($status, ['menunggu', 'pending']);

                                $jamTampil = substr((string) $booking->jam_booking, 0, 5);

                                $tanggalTampil = $booking->tanggal_booking
                                    ? \Illuminate\Support\Carbon::parse($booking->tanggal_booking)->format('d M Y')
                                    : '-';

                                $mekanik = $booking->mekanik?->name
                                    ?? $booking->mekanik?->nama
                                    ?? null;
                            @endphp

                            <tr>
                                <td>
                                    <div class="rb-strong">
                                        {{ $booking->kendaraan ?? $booking->jenis_kendaraan ?? '-' }}
                                    </div>
                                    <div class="rb-small">
                                        {{ $booking->nomor_polisi ?? $booking->plat_nomor ?? '-' }}
                                    </div>
                                </td>

                                <td>
                                    <div class="rb-strong">
                                        {{ $booking->jenis_servis ?? $booking->jenis_service ?? '-' }}
                                    </div>
                                </td>

                                <td>
                                    <div class="rb-strong">{{ $tanggalTampil }}</div>
                                    <div class="rb-small">
                                        {{ $jamTampil !== '' ? $jamTampil . ' WIB' : '-' }}
                                    </div>
                                </td>

                                <td>
                                    <div class="rb-small" style="margin-top: 0;">
                                        {{ $mekanik ?: 'Belum ditentukan' }}
                                    </div>
                                </td>

                                <td>
                                    <span class="rb-status {{ $statusClass }}">
                                        {{ ucfirst($booking->status ?? 'Menunggu') }}
                                    </span>
                                </td>

                                <td>
                                    <div class="rb-actions">
                                        <a
                                            href="{{ route('booking.show', $booking->id) }}"
                                            class="rb-link detail"
                                        >
                                            Detail
                                        </a>

                                        @if ($bisaUbah)
                                            <a
                                                href="{{ route('booking.edit', $booking->id) }}"
                                                class="rb-link edit"
                                            >
                                                Edit
                                            </a>

                                            <form
                                                action="{{ route('booking.cancel', $booking->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Yakin ingin membatalkan booking ini?')"
                                            >
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="rb-link cancel">
                                                    Batalkan
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- KARTU MOBILE --}}
            <div class="rb-mobile">
                @foreach ($bookings as $booking)
                    @php
                        $status = strtolower($booking->status ?? 'menunggu');

                        $statusClass = match ($status) {
                            'selesai' => 'selesai',
                            'ditolak', 'dibatalkan' => 'ditolak',
                            'proses', 'diproses', 'sedang dikerjakan',
                            'dikerjakan', 'disetujui', 'diterima' => 'proses',
                            default => 'menunggu',
                        };

                        $bisaUbah = in_array($status, ['menunggu', 'pending']);

                        $jamTampil = substr((string) $booking->jam_booking, 0, 5);

                        $tanggalTampil = $booking->tanggal_booking
                            ? \Illuminate\Support\Carbon::parse($booking->tanggal_booking)->format('d M Y')
                            : '-';

                        $mekanik = $booking->mekanik?->name
                            ?? $booking->mekanik?->nama
                            ?? null;
                    @endphp

                    <article class="rb-card">
                        <div class="rb-card-top">
                            <div>
                                <div class="rb-strong">
                                    {{ $booking->kendaraan ?? $booking->jenis_kendaraan ?? '-' }}
                                </div>

                                <div class="rb-small">
                                    {{ $booking->nomor_polisi ?? $booking->plat_nomor ?? '-' }}
                                </div>
                            </div>

                            <span class="rb-status {{ $statusClass }}">
                                {{ ucfirst($booking->status ?? 'Menunggu') }}
                            </span>
                        </div>

                        <div class="rb-card-grid">
                            <div>
                                <div class="rb-card-label">Jenis Servis</div>
                                <div class="rb-card-value">
                                    {{ $booking->jenis_servis ?? $booking->jenis_service ?? '-' }}
                                </div>
                            </div>

                            <div>
                                <div class="rb-card-label">Jadwal</div>
                                <div class="rb-card-value">
                                    {{ $tanggalTampil }}<br>
                                    {{ $jamTampil !== '' ? $jamTampil . ' WIB' : '-' }}
                                </div>
                            </div>

                            <div class="full">
                                <div class="rb-card-label">Mekanik</div>
                                <div class="rb-card-value">
                                    {{ $mekanik ?: 'Belum ditentukan' }}
                                </div>
                            </div>
                        </div>

                        <div class="rb-actions">
                            <a
                                href="{{ route('booking.show', $booking->id) }}"
                                class="rb-link detail"
                            >
                                Detail
                            </a>

                            @if ($bisaUbah)
                                <a
                                    href="{{ route('booking.edit', $booking->id) }}"
                                    class="rb-link edit"
                                >
                                    Edit
                                </a>

                                <form
                                    action="{{ route('booking.cancel', $booking->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('Yakin ingin membatalkan booking ini?')"
                                >
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="rb-link cancel">
                                        Batalkan
                                    </button>
                                </form>
                            @endif
                        </div>
                    </article>
                @endforeach
            </div>
        @endif
    </section>

    <div class="rb-foot">
        Bengkel Royal Motor · Riwayat Booking Servis
    </div>

</div>
@endsection