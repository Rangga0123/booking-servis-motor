@extends('layouts.customer')

@section('title', 'Riwayat Booking - Bengkel Royal Motor')

@push('styles')
<style>
    .rb-page {
        max-width: 1180px;
        margin: 0 auto;
        color: #14213d;
    }

    .rb-page * {
        box-sizing: border-box;
    }

    .rb-head {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
        flex-wrap: wrap;
        margin-bottom: 24px;
    }

    .rb-crumb {
        margin-bottom: 9px;
        font-size: 12px;
        color: #7182a3;
    }

    .rb-title {
        margin: 0;
        font-size: 28px;
        font-weight: 800;
        line-height: 1.3;
    }

    .rb-desc {
        margin-top: 8px;
        font-size: 14px;
        line-height: 1.6;
        color: #7182a3;
    }

    .rb-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 12px 18px;
        border: 0;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
        cursor: pointer;
        transition: background .2s ease, transform .2s ease;
    }

    .rb-btn:hover {
        transform: translateY(-1px);
    }

    .rb-btn-primary {
        background: #3264d8;
        color: #fff;
        box-shadow: 0 5px 14px #3264d82b;
    }

    .rb-btn-primary:hover {
        background: #244fb5;
    }

    .rb-alert {
        padding: 14px 16px;
        margin-bottom: 18px;
        border-radius: 11px;
        font-size: 13px;
        line-height: 1.7;
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
        margin-top: 6px;
        padding-left: 20px;
    }

    .rb-stats {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 16px;
        margin-bottom: 22px;
    }

    .rb-stat {
        padding: 20px;
        background: #fff;
        border: 1px solid #dae3ee;
        border-radius: 14px;
        box-shadow: 0 5px 14px #273d630b;
    }

    .rb-stat-label {
        font-size: 14px;
        font-weight: 700;
        color: #526585;
    }

    .rb-stat-number {
        margin-top: 8px;
        font-size: 32px;
        font-weight: 800;
        line-height: 1.2;
    }

    .rb-stat-number.blue {
        color: #2a5fd4;
    }

    .rb-stat-number.green {
        color: #0f7a4d;
    }

    .rb-stat-desc {
        margin-top: 6px;
        font-size: 12px;
        color: #8190a8;
    }

    .rb-panel {
        overflow: hidden;
        background: #fff;
        border: 1px solid #dce5f1;
        border-radius: 14px;
        box-shadow: 0 5px 16px #273d630b;
    }

    .rb-panel-head {
        padding: 18px 22px;
        border-bottom: 1px solid #e5ebf3;
    }

    .rb-panel-title {
        font-size: 17px;
        font-weight: 800;
    }

    .rb-panel-sub {
        margin-top: 5px;
        font-size: 13px;
        color: #8392aa;
    }

    .rb-table-wrap {
        overflow-x: auto;
    }

    .rb-table {
        width: 100%;
        min-width: 900px;
        border-collapse: collapse;
        text-align: left;
    }

    .rb-table thead {
        background: #eaf0fa;
    }

    .rb-table th {
        padding: 15px 16px;
        font-size: 12px;
        font-weight: 800;
        color: #2a3c5e;
        white-space: nowrap;
        border-bottom: 2px solid #d3deee;
    }

    .rb-table td {
        padding: 16px;
        border-bottom: 1px solid #e7edf5;
        font-size: 13px;
        color: #3c5070;
        vertical-align: middle;
    }

    .rb-table tbody tr:nth-child(even) {
        background: #f8fafd;
    }

    .rb-table tbody tr:hover {
        background: #eef4ff;
    }

    .rb-table tbody tr:last-child td {
        border-bottom: 0;
    }

    .rb-strong {
        font-size: 14px;
        font-weight: 800;
        color: #1b2a47;
        overflow-wrap: anywhere;
    }

    .rb-small {
        margin-top: 4px;
        font-size: 12px;
        color: #7b8cab;
    }

    .rb-status {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 6px 11px;
        border-radius: 30px;
        font-size: 11px;
        font-weight: 800;
        white-space: nowrap;
    }

    .rb-status.selesai {
        color: #0f7a4d;
        background: #d6f5e5;
    }

    .rb-status.proses {
        color: #2a5fd4;
        background: #e8f1ff;
    }

    .rb-status.ditolak {
        color: #c4253f;
        background: #ffe5e9;
    }

    .rb-status.menunggu {
        color: #b87400;
        background: #fff2d7;
    }

    .rb-actions {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        align-items: center;
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
        padding: 8px 11px;
        border: 0;
        border-radius: 8px;
        font-size: 11px;
        font-weight: 800;
        line-height: 1.3;
        text-decoration: none;
        white-space: nowrap;
        cursor: pointer;
        transition: background .2s ease, transform .2s ease;
    }

    .rb-link:hover {
        transform: translateY(-1px);
    }

    .rb-link.detail {
        background: #e0f2fe;
        color: #075985;
    }

    .rb-link.detail:hover {
        background: #bae6fd;
    }

    .rb-link.edit {
        background: #fff0c2;
        color: #8a5100;
    }

    .rb-link.edit:hover {
        background: #ffe39a;
    }

    .rb-link.cancel {
        background: #ffe5e9;
        color: #c4253f;
    }

    .rb-link.cancel:hover {
        background: #ffcbd3;
    }

    .rb-empty {
        padding: 56px 20px;
        text-align: center;
    }

    .rb-empty h3 {
        margin: 0;
        font-size: 18px;
        font-weight: 800;
    }

    .rb-empty p {
        max-width: 420px;
        margin: 8px auto 20px;
        font-size: 14px;
        line-height: 1.7;
        color: #7182a3;
    }

    .rb-mobile {
        display: none;
        padding: 14px;
    }

    .rb-card {
        padding: 16px;
        margin-bottom: 12px;
        border: 1px solid #dde5f0;
        border-radius: 13px;
        background: #fff;
    }

    .rb-card:last-child {
        margin-bottom: 0;
    }

    .rb-card-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 10px;
    }

    .rb-card-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 14px;
        margin-top: 14px;
        padding-top: 14px;
        border-top: 1px solid #edf1f7;
    }

    .rb-card-grid .full {
        grid-column: 1 / -1;
    }

    .rb-card-label {
        font-size: 12px;
        color: #7b8cab;
    }

    .rb-card-value {
        margin-top: 4px;
        font-size: 13px;
        font-weight: 700;
        color: #263956;
        overflow-wrap: anywhere;
    }

    .rb-card .rb-actions {
        justify-content: flex-start;
        margin-top: 14px;
        padding-top: 14px;
        border-top: 1px solid #edf1f7;
    }

    .rb-foot {
        margin-top: 22px;
        text-align: center;
        font-size: 12px;
        color: #97a5bd;
    }

    @media (max-width: 1000px) {
        .rb-table th,
        .rb-table td {
            padding: 13px 10px;
        }

        .rb-link {
            padding: 8px 9px;
        }
    }

    @media (max-width: 800px) {
        .rb-stats {
            grid-template-columns: 1fr;
            gap: 10px;
        }

        .rb-table-wrap {
            display: none;
        }

        .rb-mobile {
            display: block;
        }
    }

    @media (max-width: 650px) {
        .rb-title {
            font-size: 24px;
        }

        .rb-head .rb-btn {
            width: 100%;
        }

        .rb-stat {
            padding: 16px;
        }

        .rb-stat-number {
            font-size: 28px;
        }

        .rb-panel-head {
            padding: 16px;
        }

        .rb-card-top {
            flex-wrap: wrap;
        }

        .rb-card .rb-actions {
            gap: 8px;
        }

        .rb-card .rb-link {
            padding: 9px 12px;
        }
    }
</style>
@endpush

@section('content')
<div class="rb-page">

    <section class="rb-head">
        <div>
            <div class="rb-crumb">Pelanggan / Riwayat Booking</div>
            <h1 class="rb-title">Riwayat Booking</h1>
            <p class="rb-desc">
                Lihat detail, jadwal, dan status servis motor yang sudah Anda booking.
            </p>
        </div>

        <a href="{{ route('booking.create') }}" class="rb-btn rb-btn-primary">
            <svg width="18" height="18" viewBox="0 0 24 24"
                 fill="none" stroke="currentColor" stroke-width="2">
                <path d="M12 5v14M5 12h14"/>
            </svg>
            Booking Baru
        </a>
    </section>

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
            <strong>Periksa kembali data yang Anda masukkan.</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <section class="rb-stats">
        <div class="rb-stat">
            <div class="rb-stat-label">Total Booking</div>
            <div class="rb-stat-number">
                {{ $totalBooking ?? $bookings->count() }}
            </div>
            <div class="rb-stat-desc">Semua pesanan milik Anda</div>
        </div>

        <div class="rb-stat">
            <div class="rb-stat-label">Sedang Diproses</div>
            <div class="rb-stat-number blue">
                {{ $statusDiproses ?? 0 }}
            </div>
            <div class="rb-stat-desc">Pesanan dalam penanganan</div>
        </div>

        <div class="rb-stat">
            <div class="rb-stat-label">Servis Selesai</div>
            <div class="rb-stat-number green">
                {{ $servisSelesai ?? 0 }}
            </div>
            <div class="rb-stat-desc">Pesanan yang telah selesai</div>
        </div>
    </section>

    <section class="rb-panel">
        <div class="rb-panel-head">
            <div class="rb-panel-title">Riwayat Booking Saya</div>
            <div class="rb-panel-sub">
                Informasi pesanan, status, dan tindakan untuk setiap booking.
            </div>
        </div>

        @if ($bookings->isEmpty())
            <div class="rb-empty">
                <h3>Belum Ada Booking</h3>
                <p>
                    Pesanan servis yang Anda buat akan muncul di halaman ini.
                    Yuk, buat booking pertama Anda.
                </p>
                <a href="{{ route('booking.create') }}"
                   class="rb-btn rb-btn-primary">
                    Buat Booking Pertama
                </a>
            </div>
        @else

            {{-- TABEL UNTUK DESKTOP --}}
            <div class="rb-table-wrap">
                <table class="rb-table">
                    <thead>
                        <tr>
                            <th>Kendaraan</th>
                            <th>Jenis Servis</th>
                            <th>Jadwal</th>
                            <th>Mekanik</th>
                            <th>Status</th>
                            <th style="text-align:center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($bookings as $booking)
                            @php
                                $status = strtolower(trim($booking->status ?? 'menunggu'));

                                $statusClass = match ($status) {
                                    'selesai' => 'selesai',
                                    'ditolak', 'dibatalkan' => 'ditolak',
                                    'diproses', 'proses', 'sedang dikerjakan',
                                    'dikerjakan', 'disetujui' => 'proses',
                                    default => 'menunggu',
                                };

                                $statusLabel = match ($status) {
                                    'pending' => 'Menunggu',
                                    'proses' => 'Diproses',
                                    'disetujui' => 'Disetujui',
                                    'dikerjakan', 'sedang dikerjakan' => 'Sedang Dikerjakan',
                                    'dibatalkan' => 'Dibatalkan',
                                    default => ucfirst($status),
                                };

                                $bisaDiedit = in_array($status, ['menunggu', 'pending']);
                            @endphp

                            <tr>
                                <td>
                                    <div class="rb-strong">
                                        {{ $booking->nama_motor }}
                                    </div>
                                    <div class="rb-small">
                                        {{ $booking->plat_nomor }}
                                    </div>
                                </td>

                                <td>{{ $booking->jenis_servis }}</td>

                                <td>
                                    <div class="rb-strong">
                                        {{ $booking->tanggal_booking
                                            ? \Illuminate\Support\Carbon::parse($booking->tanggal_booking)->format('d M Y')
                                            : '-' }}
                                    </div>
                                    <div class="rb-small">
                                        {{ $booking->jam_booking
                                            ? substr((string) $booking->jam_booking, 0, 5) . ' WIB'
                                            : '-' }}
                                    </div>
                                </td>

                                <td>
                                    {{ $booking->mechanic->nama_mekanik ?? 'Belum ditentukan' }}
                                </td>

                                <td>
                                    <span class="rb-status {{ $statusClass }}">
                                        {{ $statusLabel }}
                                    </span>
                                </td>

                                <td>
                                    <div class="rb-actions">
                                        <a href="{{ route('booking.show', $booking->id) }}"
                                           class="rb-link detail">
                                            Detail
                                        </a>

                                        @if ($bisaDiedit)
                                            <a href="{{ route('booking.edit', $booking->id) }}"
                                               class="rb-link edit">
                                                Edit
                                            </a>

                                            <form action="{{ route('booking.cancel', $booking->id) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('Yakin ingin membatalkan booking ini?')">
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

            {{-- KARTU UNTUK HP --}}
            <div class="rb-mobile">
                @foreach ($bookings as $booking)
                    @php
                        $status = strtolower(trim($booking->status ?? 'menunggu'));

                        $statusClass = match ($status) {
                            'selesai' => 'selesai',
                            'ditolak', 'dibatalkan' => 'ditolak',
                            'diproses', 'proses', 'sedang dikerjakan',
                            'dikerjakan', 'disetujui' => 'proses',
                            default => 'menunggu',
                        };

                        $statusLabel = match ($status) {
                            'pending' => 'Menunggu',
                            'proses' => 'Diproses',
                            'disetujui' => 'Disetujui',
                            'dikerjakan', 'sedang dikerjakan' => 'Sedang Dikerjakan',
                            'dibatalkan' => 'Dibatalkan',
                            default => ucfirst($status),
                        };

                        $bisaDiedit = in_array($status, ['menunggu', 'pending']);
                    @endphp

                    <article class="rb-card">
                        <div class="rb-card-top">
                            <div>
                                <div class="rb-strong">
                                    {{ $booking->nama_motor }}
                                </div>
                                <div class="rb-small">
                                    {{ $booking->plat_nomor }}
                                </div>
                            </div>

                            <span class="rb-status {{ $statusClass }}">
                                {{ $statusLabel }}
                            </span>
                        </div>

                        <div class="rb-card-grid">
                            <div>
                                <div class="rb-card-label">Jenis Servis</div>
                                <div class="rb-card-value">
                                    {{ $booking->jenis_servis }}
                                </div>
                            </div>

                            <div>
                                <div class="rb-card-label">Jadwal</div>
                                <div class="rb-card-value">
                                    {{ $booking->tanggal_booking
                                        ? \Illuminate\Support\Carbon::parse($booking->tanggal_booking)->format('d M Y')
                                        : '-' }}
                                </div>
                                <div class="rb-small">
                                    {{ $booking->jam_booking
                                        ? substr((string) $booking->jam_booking, 0, 5) . ' WIB'
                                        : '-' }}
                                </div>
                            </div>

                            <div class="full">
                                <div class="rb-card-label">Mekanik</div>
                                <div class="rb-card-value">
                                    {{ $booking->mechanic->nama_mekanik ?? 'Belum ditentukan' }}
                                </div>
                            </div>
                        </div>

                        <div class="rb-actions">
                            <a href="{{ route('booking.show', $booking->id) }}"
                               class="rb-link detail">
                                Detail
                            </a>

                            @if ($bisaDiedit)
                                <a href="{{ route('booking.edit', $booking->id) }}"
                                   class="rb-link edit">
                                    Edit
                                </a>

                                <form action="{{ route('booking.cancel', $booking->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Yakin ingin membatalkan booking ini?')">
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

    <p class="rb-foot">Royal Motor · Booking Servis Motor</p>
</div>
@endsection