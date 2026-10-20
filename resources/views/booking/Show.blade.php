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
        'dibatalkan', 'batal' => 'Dibatalkan',
        default => ucfirst($booking->status ?? 'Menunggu'),
    };

    $warnaStatus = match ($status) {
        'selesai' => 'success',
        'dibatalkan', 'batal' => 'danger',
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
        max-width: 1100px;
        margin: 0 auto;
        padding: 26px 20px 40px;
        color: #14213d;
        box-sizing: border-box;
    }

    .detail-page *,
    .detail-page *::before,
    .detail-page *::after {
        box-sizing: border-box;
    }

    .detail-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
        flex-wrap: wrap;
        margin-bottom: 22px;
    }

    .detail-heading h1 {
        margin: 0 0 6px;
        font-size: 27px;
        font-weight: 750;
        line-height: 1.4;
        color: #14213d;
    }

    .detail-heading p {
        margin: 0;
        color: #718096;
        font-size: 13px;
        line-height: 1.7;
    }

    .detail-back {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 40px;
        padding: 9px 14px;
        border: 1px solid #dce5f1;
        border-radius: 8px;
        background: #fff;
        color: #344767;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        transition: .2s ease;
    }

    .detail-back:hover {
        background: #f5f8ff;
        border-color: #b8c9e5;
        color: #244fae;
    }

    /* Ringkasan pesanan */
    .detail-summary {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        padding: 22px;
        margin-bottom: 18px;
        border: 1px solid #dce5f1;
        border-radius: 12px;
        background: #fff;
    }

    .detail-summary-info {
        min-width: 0;
    }

    .detail-eyebrow {
        display: block;
        margin-bottom: 7px;
        color: #718096;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: .5px;
        text-transform: uppercase;
    }

    .detail-summary h2 {
        margin: 0;
        font-size: 20px;
        font-weight: 750;
        line-height: 1.5;
        overflow-wrap: anywhere;
    }

    .detail-summary-meta {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
        margin-top: 8px;
        color: #718096;
        font-size: 13px;
    }

    .detail-status {
        flex-shrink: 0;
        padding: 7px 11px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 700;
        white-space: nowrap;
    }

    .detail-status.waiting {
        background: #fff7df;
        color: #946200;
    }

    .detail-status.process {
        background: #edf4ff;
        color: #2455a4;
    }

    .detail-status.success {
        background: #eaf7ee;
        color: #267342;
    }

    .detail-status.danger {
        background: #fff0f0;
        color: #b42323;
    }

    /* Informasi booking */
    .detail-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 16px;
    }

    .detail-card {
        min-width: 0;
        padding: 21px;
        border: 1px solid #dce5f1;
        border-radius: 12px;
        background: #fff;
    }

    .detail-card.full {
        grid-column: 1 / -1;
    }

    .detail-card-heading {
        padding-bottom: 13px;
        margin-bottom: 18px;
        border-bottom: 1px solid #edf1f7;
    }

    .detail-card-heading h3 {
        margin: 0;
        color: #14213d;
        font-size: 15px;
        font-weight: 750;
    }

    .detail-card-heading p {
        margin: 4px 0 0;
        color: #8794a9;
        font-size: 12px;
        line-height: 1.6;
    }

    .detail-list {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 20px 18px;
    }

    .detail-item {
        min-width: 0;
    }

    .detail-item.full {
        grid-column: 1 / -1;
    }

    .detail-label {
        display: block;
        margin-bottom: 6px;
        color: #718096;
        font-size: 12px;
        line-height: 1.5;
    }

    .detail-value {
        display: block;
        color: #263750;
        font-size: 13px;
        font-weight: 650;
        line-height: 1.7;
        overflow-wrap: anywhere;
        white-space: pre-line;
    }

    .detail-value.muted {
        color: #929eaf;
        font-weight: 400;
    }

    .detail-complaint {
        padding: 13px 14px;
        border: 1px solid #e4eaf2;
        border-radius: 8px;
        background: #fafbfd;
        color: #344767;
        font-size: 13px;
        line-height: 1.8;
        overflow-wrap: anywhere;
        white-space: pre-line;
    }

    /* Tombol */
    .detail-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        flex-wrap: wrap;
        margin-top: 20px;
    }

    .detail-footer-note {
        color: #8794a9;
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
        padding: 10px 15px;
        border: 1px solid #dce5f1;
        border-radius: 8px;
        font-family: inherit;
        font-size: 13px;
        font-weight: 650;
        text-decoration: none;
        cursor: pointer;
        transition: .2s ease;
    }

    .detail-button.back {
        background: #fff;
        color: #344767;
    }

    .detail-button.back:hover {
        background: #f5f8ff;
        border-color: #b8c9e5;
    }

    .detail-button.edit {
        border-color: #3264d8;
        background: #3264d8;
        color: #fff;
    }

    .detail-button.edit:hover {
        border-color: #244fae;
        background: #244fae;
    }

    /* Tampilan HP */
    @media (max-width: 700px) {
        .detail-page {
            padding: 20px 14px 30px;
        }

        .detail-heading h1 {
            font-size: 23px;
        }

        .detail-header {
            align-items: flex-start;
        }

        .detail-summary {
            padding: 18px;
        }

        .detail-summary h2 {
            font-size: 18px;
        }

        .detail-grid {
            grid-template-columns: 1fr;
            gap: 14px;
        }

        .detail-card,
        .detail-card.full {
            grid-column: auto;
            padding: 18px;
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

    @media (max-width: 420px) {
        .detail-summary {
            align-items: flex-start;
            flex-direction: column;
        }

        .detail-list {
            grid-template-columns: 1fr;
            gap: 17px;
        }

        .detail-item.full {
            grid-column: auto;
        }

        .detail-footer-note {
            font-size: 11px;
        }
    }
</style>

<div class="detail-page">

    <div class="detail-header">
        <div class="detail-heading">
            <h1>Detail Pesanan</h1>
            <p>Lihat informasi booking servis motor kamu.</p>
        </div>

        <a href="{{ route('booking.index') }}" class="detail-back">
            Kembali ke Riwayat
        </a>
    </div>

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
                    <span class="detail-value">{{ $tanggalTampil }}</span>
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

        {{-- Keluhan --}}
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