@extends('layouts.customer')

@section('title', 'Detail Pesanan')

@section('content')
@php
    $jamTampil = $booking->jam_booking
        ? substr((string) $booking->jam_booking, 0, 5)
        : '-';

    $tanggalTampil = $booking->tanggal_booking
        ? \Illuminate\Support\Carbon::parse($booking->tanggal_booking)->format('d M Y')
        : '-';

    $status = strtolower(trim($booking->status ?? 'menunggu'));

    $statusTampil = match ($status) {
        'menunggu', 'pending' => 'Menunggu',
        'proses', 'diproses' => 'Diproses',
        'sedang dikerjakan', 'dikerjakan' => 'Sedang Dikerjakan',
        'disetujui' => 'Disetujui',
        'selesai' => 'Selesai',
        'ditolak' => 'Ditolak',
        'dibatalkan', 'batal' => 'Dibatalkan',
        default => ucfirst($booking->status ?? 'Menunggu'),
    };

    $warnaStatus = match ($status) {
        'selesai' => 'success',
        'dibatalkan', 'batal', 'ditolak' => 'danger',
        'proses', 'diproses', 'sedang dikerjakan', 'dikerjakan', 'disetujui' => 'process',
        default => 'waiting',
    };

    $bisaDiubah = in_array($status, ['menunggu', 'pending'], true);

    $namaMekanik = $booking->mechanic?->nama_mekanik
        ?? 'Belum ditentukan';

    $metodePembayaran = $booking->metode_pembayaran
        ?: 'Belum ditentukan';
@endphp

<style>
    .detail-page {
        width: 100%;
        max-width: 1200px;
        margin: 0 auto;
        padding: 26px 22px 40px;
        color: #343a40;
        box-sizing: border-box;
    }

    .detail-page *,
    .detail-page *::before,
    .detail-page *::after {
        box-sizing: border-box;
    }

    /* Header halaman */
    .detail-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        flex-wrap: wrap;
        margin-bottom: 22px;
    }

    .detail-heading h1 {
        margin: 0 0 7px;
        color: #343a40;
        font-size: 27px;
        font-weight: 800;
        line-height: 1.3;
    }

    .detail-heading p {
        margin: 0;
        color: #747d87;
        font-size: 13px;
        line-height: 1.7;
    }

    .detail-back {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 41px;
        padding: 10px 16px;
        border: 1px solid #d5d9de;
        border-radius: 7px;
        background: #fff;
        color: #495057;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
        transition: background .2s, border-color .2s;
    }

    .detail-back:hover {
        background: #f1f3f5;
        border-color: #bfc5cc;
    }

    /* Ringkasan booking */
    .detail-summary {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 18px;
        padding: 22px;
        margin-bottom: 20px;
        border: 1px solid #dfe3e8;
        border-left: 4px solid #6c8fc7;
        border-radius: 9px;
        background: #f7f8fa;
    }

    .detail-summary-info {
        min-width: 0;
    }

    .detail-eyebrow {
        display: block;
        margin-bottom: 7px;
        color: #737d88;
        font-size: 12px;
        font-weight: 700;
    }

    .detail-summary h2 {
        margin: 0;
        color: #343a40;
        font-size: 20px;
        font-weight: 800;
        line-height: 1.5;
        overflow-wrap: anywhere;
    }

    .detail-summary-meta {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
        margin-top: 8px;
        color: #626b75;
        font-size: 13px;
    }

    .detail-status {
        flex-shrink: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 7px 13px;
        border: 1px solid transparent;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 800;
        white-space: nowrap;
    }

    .detail-status.waiting {
        background: #fff4d9;
        border-color: #f1dfae;
        color: #88631b;
    }

    .detail-status.process {
        background: #e8eff9;
        border-color: #cedcf1;
        color: #355b8e;
    }

    .detail-status.success {
        background: #e0f2e8;
        border-color: #c4e5d2;
        color: #26734d;
    }

    .detail-status.danger {
        background: #fbe8e9;
        border-color: #f0cdd0;
        color: #a33e46;
    }

    /* Informasi penolakan */
    .detail-reject {
        padding: 18px 20px;
        margin-bottom: 20px;
        border: 1px solid #e8c9cc;
        border-left: 4px solid #c96c74;
        border-radius: 8px;
        background: #fff8f8;
    }

    .detail-reject strong {
        display: block;
        margin-bottom: 7px;
        color: #a33e46;
        font-size: 13px;
        font-weight: 800;
    }

    .detail-reject p {
        margin: 0;
        color: #65474a;
        font-size: 13px;
        line-height: 1.8;
        overflow-wrap: anywhere;
        white-space: pre-line;
    }

    .detail-reject small {
        display: block;
        margin-top: 10px;
        color: #8a6669;
        font-size: 12px;
        line-height: 1.6;
    }

    /* Susunan kotak informasi */
    .detail-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 18px;
        align-items: stretch;
    }

    .detail-card {
        min-width: 0;
        padding: 21px;
        border: 1px solid #dfe3e8;
        border-radius: 9px;
        background: #fff;
        box-shadow: 0 2px 5px rgba(35, 45, 55, .025);
    }

    .detail-card.full {
        grid-column: 1 / -1;
    }

    .detail-card-heading {
        padding-bottom: 13px;
        margin-bottom: 18px;
        border-bottom: 2px solid #e2e5e9;
    }

    .detail-card-heading h3 {
        margin: 0;
        color: #424950;
        font-size: 15px;
        font-weight: 800;
        line-height: 1.5;
    }

    .detail-card-heading p {
        margin: 4px 0 0;
        color: #7b838c;
        font-size: 12px;
        line-height: 1.6;
    }

    /* Setiap data dipisahkan garis */
    .detail-list {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 0 18px;
    }

    .detail-item {
        min-width: 0;
        min-height: 67px;
        padding: 13px 12px;
        border: 1px solid #e2e5e9;
        border-radius: 6px;
        background: #fafbfc;
        margin-bottom: 10px;
    }

    .detail-item.full {
        grid-column: 1 / -1;
    }

    .detail-label {
        display: block;
        margin-bottom: 6px;
        color: #747d87;
        font-size: 12px;
        line-height: 1.5;
    }

    .detail-value {
        display: block;
        color: #343a40;
        font-size: 14px;
        font-weight: 700;
        line-height: 1.65;
        overflow-wrap: anywhere;
        white-space: pre-line;
    }

    .detail-value.muted {
        color: #929aa3;
        font-weight: 400;
    }

    /* Keluhan atau catatan */
    .detail-complaint {
        min-height: 70px;
        padding: 15px;
        border: 1px solid #e0e4e8;
        border-radius: 7px;
        background: #f8f9fa;
        color: #495057;
        font-size: 14px;
        line-height: 1.8;
        overflow-wrap: anywhere;
        white-space: pre-line;
    }

    /* Bagian tombol bawah */
    .detail-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        flex-wrap: wrap;
        padding-top: 18px;
        margin-top: 22px;
        border-top: 1px solid #e1e4e8;
    }

    .detail-footer-note {
        color: #747d87;
        font-size: 12px;
        line-height: 1.7;
    }

    .detail-actions {
        display: flex;
        align-items: center;
        gap: 9px;
        flex-wrap: wrap;
    }

    .detail-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 41px;
        padding: 10px 18px;
        border: 1px solid #d5d9de;
        border-radius: 7px;
        font-family: inherit;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
        cursor: pointer;
        transition: background .2s, border-color .2s;
    }

    .detail-button.back {
        background: #fff;
        color: #495057;
    }

    .detail-button.back:hover {
        background: #f1f3f5;
        border-color: #bfc5cc;
    }

    .detail-button.edit {
        border-color: #527bb8;
        background: #527bb8;
        color: #fff;
    }

    .detail-button.edit:hover {
        border-color: #3f659e;
        background: #3f659e;
    }

    /* Responsif tablet dan HP */
    @media (max-width: 760px) {
        .detail-page {
            padding: 21px 15px 30px;
        }

        .detail-heading h1 {
            font-size: 24px;
        }

        .detail-grid {
            grid-template-columns: 1fr;
            gap: 14px;
        }

        .detail-card,
        .detail-card.full {
            grid-column: auto;
        }
    }

    @media (max-width: 520px) {
        .detail-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .detail-back {
            width: 100%;
        }

        .detail-summary {
            align-items: flex-start;
            flex-direction: column;
            padding: 18px;
        }

        .detail-summary h2 {
            font-size: 18px;
        }

        .detail-card {
            padding: 16px;
        }

        .detail-list {
            grid-template-columns: 1fr;
            gap: 0;
        }

        .detail-item.full {
            grid-column: auto;
        }

        .detail-footer {
            align-items: stretch;
            flex-direction: column;
        }

        .detail-actions {
            display: grid;
            grid-template-columns: 1fr;
            width: 100%;
        }

        .detail-button {
            width: 100%;
        }
    }
</style>

<div class="detail-page">

    {{-- Header halaman --}}
    <div class="detail-header">
        <div class="detail-heading">
            <h1>Detail Pesanan</h1>
            <p>Lihat informasi booking servis motor kamu.</p>
        </div>

        <a href="{{ route('booking.index') }}" class="detail-back">
            Kembali ke Riwayat
        </a>
    </div>

    {{-- Ringkasan booking --}}
    <div class="detail-summary">
        <div class="detail-summary-info">
            <span class="detail-eyebrow">Ringkasan Booking</span>

            <h2>{{ $booking->jenis_servis ?: 'Servis Motor' }}</h2>

            <div class="detail-summary-meta">
                <span>{{ $tanggalTampil }}</span>
                <span>·</span>
                <span>
                    {{ $jamTampil }}{{ $jamTampil !== '-' ? ' WIB' : '' }}
                </span>
            </div>
        </div>

        <span class="detail-status {{ $warnaStatus }}">
            {{ $statusTampil }}
        </span>
    </div>

    {{-- Alasan penolakan dari admin --}}
    @if ($status === 'ditolak')
        <div class="detail-reject">
            <strong>Pesanan kamu ditolak</strong>

            <p>{{ $booking->alasan_penolakan ?: 'Admin tidak mencantumkan alasan penolakan.' }}</p>

            <small>
                Kamu bisa membuat booking baru dengan jadwal lain lewat menu Booking.
            </small>
        </div>
    @endif

    <div class="detail-grid">

        {{-- Data pelanggan --}}
        <section class="detail-card">
            <div class="detail-card-heading">
                <h3>Data Pelanggan</h3>
                <p>Informasi pemesan servis</p>
            </div>

            <div class="detail-list">
                <div class="detail-item">
                    <span class="detail-label">Nama Pelanggan</span>
                    <span class="detail-value">
                        {{ $booking->nama_pelanggan ?: '-' }}
                    </span>
                </div>

                <div class="detail-item">
                    <span class="detail-label">Nomor HP</span>
                    <span class="detail-value">
                        {{ $booking->no_hp ?: '-' }}
                    </span>
                </div>

                <div class="detail-item full">
                    <span class="detail-label">Email</span>
                    <span class="detail-value {{ empty($booking->email_pelanggan) ? 'muted' : '' }}">
                        {{ $booking->email_pelanggan ?: 'Email tidak dicantumkan' }}
                    </span>
                </div>
            </div>
        </section>

        {{-- Data kendaraan --}}
        <section class="detail-card">
            <div class="detail-card-heading">
                <h3>Data Kendaraan</h3>
                <p>Motor yang akan diservis</p>
            </div>

            <div class="detail-list">
                <div class="detail-item">
                    <span class="detail-label">Nama / Tipe Motor</span>
                    <span class="detail-value">
                        {{ $booking->nama_motor ?: '-' }}
                    </span>
                </div>

                <div class="detail-item">
                    <span class="detail-label">Nomor Polisi</span>
                    <span class="detail-value">
                        {{ $booking->plat_nomor ?: '-' }}
                    </span>
                </div>
            </div>
        </section>

        {{-- Informasi servis --}}
        <section class="detail-card">
            <div class="detail-card-heading">
                <h3>Informasi Servis</h3>
                <p>Jenis layanan dan jadwal booking</p>
            </div>

            <div class="detail-list">
                <div class="detail-item full">
                    <span class="detail-label">Jenis Servis</span>
                    <span class="detail-value">
                        {{ $booking->jenis_servis ?: '-' }}
                    </span>
                </div>

                <div class="detail-item">
                    <span class="detail-label">Tanggal Booking</span>
                    <span class="detail-value">
                        {{ $tanggalTampil }}
                    </span>
                </div>

                <div class="detail-item">
                    <span class="detail-label">Jam Booking</span>
                    <span class="detail-value">
                        {{ $jamTampil }}{{ $jamTampil !== '-' ? ' WIB' : '' }}
                    </span>
                </div>

                <div class="detail-item full">
                    <span class="detail-label">Mekanik</span>
                    <span class="detail-value {{ $namaMekanik === 'Belum ditentukan' ? 'muted' : '' }}">
                        {{ $namaMekanik }}
                    </span>
                </div>
            </div>
        </section>

        {{-- Pembayaran --}}
        <section class="detail-card">
            <div class="detail-card-heading">
                <h3>Pembayaran</h3>
                <p>Metode pembayaran yang dipilih</p>
            </div>

            <div class="detail-list">
                <div class="detail-item full">
                    <span class="detail-label">Metode Pembayaran</span>
                    <span class="detail-value {{ $metodePembayaran === 'Belum ditentukan' ? 'muted' : '' }}">
                        {{ $metodePembayaran }}
                    </span>
                </div>
            </div>
        </section>

        {{-- Keluhan servis --}}
        <section class="detail-card full">
            <div class="detail-card-heading">
                <h3>Keluhan / Catatan Servis</h3>
                <p>Keluhan yang disampaikan saat booking</p>
            </div>

            <div class="detail-complaint">
                {{ $booking->keluhan ?: 'Tidak ada keluhan yang ditambahkan.' }}
            </div>
        </section>

    </div>

    {{-- Tombol navigasi --}}
    <div class="detail-footer">
        <span class="detail-footer-note">
            Pastikan data booking kamu sudah sesuai.
        </span>

        <div class="detail-actions">
            <a href="{{ route('booking.index') }}" class="detail-button back">
                Kembali ke Riwayat
            </a>

            @if ($bisaDiubah)
                <a href="{{ route('booking.edit', $booking->id) }}" class="detail-button edit">
                    Edit Pesanan
                </a>
            @endif
        </div>
    </div>

</div>
@endsection