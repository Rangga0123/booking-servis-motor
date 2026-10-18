@extends('layouts.customer')

@section('title', 'Dashboard Pelanggan - Bengkel Royal Motor')

@push('styles')
<style>
    /* ===== DASHBOARD UTAMA ===== */
    .dashboard-content {
        width: 100%;
        max-width: 1500px;
        margin: 0 auto;
        padding-bottom: 22px;
        color: #14213d;
    }

    .welcome,
    .stat-card,
    .info-card {
        animation: none;
    }

    /* ===== SAMBUTAN PELANGGAN ===== */
    .welcome {
        min-height: 94px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        padding: 16px 20px;
        margin-bottom: 15px;
        border: 1px solid #c9dcf8;
        border-radius: 14px;
        background: linear-gradient(115deg, #d8e6ff 0%, #e8f7ff 100%);
        box-shadow: 0 3px 12px #325da40a;
    }

    .welcome-left {
        display: flex;
        align-items: center;
        gap: 13px;
        min-width: 0;
    }

    .welcome-hand {
        width: 45px;
        height: 45px;
        flex: 0 0 45px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        background: #ffffffc9;
        color: #2d5eb8;
    }

    .welcome h1 {
        font-size: 22px;
        font-weight: 800;
        line-height: 1.35;
        color: #102143;
    }

    .welcome p {
        margin-top: 4px;
        font-size: 12px;
        line-height: 1.65;
        color: #3d5790;
    }

    .date-box {
        min-width: 205px;
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 12px;
        border: 1px solid #c7daf2;
        border-radius: 12px;
        background: #ffffffd9;
    }

    .date-icon {
        width: 36px;
        height: 36px;
        flex: 0 0 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        background: #e5efff;
        color: #3b65bc;
    }

    .date-text {
        margin-bottom: 4px;
        color: #526b91;
        font-size: 11px;
        line-height: 1.5;
    }

    .time-text {
        color: #14213d;
        font-size: 15px;
        font-weight: 800;
        font-variant-numeric: tabular-nums;
    }

    /* ===== STATISTIK BOOKING ===== */
    .stats {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 14px;
        margin-bottom: 22px;
    }

    .stat-card {
        min-width: 0;
        min-height: 112px;
        display: flex;
        align-items: center;
        gap: 13px;
        padding: 16px;
        background: #fff;
        border: 1px solid #dce5f0;
        border-bottom: 3px solid #4285f4;
        border-radius: 13px;
        box-shadow: 0 3px 12px #273d6309;
        transition: box-shadow .2s ease, border-color .2s ease;
    }

    .stat-card:hover {
        box-shadow: 0 6px 17px #273d6312;
    }

    .stat-card.stat-orange {
        border-bottom-color: #f7a11a;
    }

    .stat-card.stat-green {
        border-bottom-color: #21b989;
    }

    .stat-icon {
        width: 46px;
        height: 46px;
        flex: 0 0 46px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 13px;
    }

    .stat-blue .stat-icon {
        color: #3580ff;
        background: #e8f0ff;
    }

    .stat-orange .stat-icon {
        color: #e98a12;
        background: #fff1dc;
    }

    .stat-green .stat-icon {
        color: #12a77b;
        background: #def6ed;
    }

    .stat-title {
        color: #4c5c77;
        font-size: 12px;
        font-weight: 700;
        line-height: 1.5;
    }

    .stat-number {
        margin-top: 3px;
        color: #14213d;
        font-size: 27px;
        font-weight: 800;
        line-height: 1.3;
    }

    .stat-description {
        margin-top: 4px;
        color: #7888a2;
        font-size: 10px;
        line-height: 1.5;
    }

    /* ===== JUDUL BAGIAN ===== */
    .section-heading {
        margin: 0 0 13px;
    }

    .section-heading h2 {
        color: #14213d;
        font-size: 19px;
        font-weight: 800;
        line-height: 1.4;
    }

    .section-heading p {
        margin-top: 3px;
        color: #7182a3;
        font-size: 12px;
        line-height: 1.6;
    }

    /* ===== KARTU INFORMASI ===== */
    .info-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        align-items: stretch;
        gap: 15px;
    }

    .info-card {
        min-width: 0;
        display: flex;
        flex-direction: column;
        overflow: hidden;
        background: #fff;
        border: 1px solid #dce5f1;
        border-radius: 13px;
        box-shadow: 0 3px 12px #273d6309;
    }

    .info-card.full {
        grid-column: 1 / -1;
    }

    .info-card-header {
        padding: 13px 16px;
        border-bottom: 1px solid #e8edf5;
        background: #fff;
    }

    .info-card-header h3 {
        color: #14213d;
        font-size: 14px;
        font-weight: 800;
        line-height: 1.5;
        overflow-wrap: anywhere;
    }

    .info-card-header p {
        margin-top: 3px;
        color: #7182a3;
        font-size: 11px;
        line-height: 1.55;
    }

    .info-card-body {
        flex: 1;
        padding: 14px 16px;
        color: #50617d;
        font-size: 12px;
        line-height: 1.8;
        overflow-wrap: anywhere;
    }

    /* ===== GAMBAR BENGKEL DAN LAYANAN ===== */
    .workshop-photo {
        display: block;
        width: 100%;
        height: 390px;
        object-fit: cover;
        object-position: center;
        border-radius: 10px;
        background: #f1f5f9;
    }

    /* Tampilan HP */
    @media (max-width: 600px) {
        .workshop-photo {
            height: 145px;
        }
    }

    .photo-caption {
        padding: 9px 16px;
        color: #50617d;
        font-size: 11px;
        line-height: 1.7;
        background: #fbfcfe;
        border-bottom: 1px solid #edf1f7;
        overflow-wrap: anywhere;
    }

    /* ===== STATUS OPERASIONAL ===== */
    .operational-status {
        display: inline-flex;
        align-items: center;
        padding: 6px 10px;
        margin-bottom: 10px;
        border-radius: 20px;
        font-size: 10px;
        font-weight: 800;
        line-height: 1.4;
    }

    .operational-status.open {
        color: #16865f;
        background: #def6ed;
    }

    .operational-status.closed {
        color: #c52f47;
        background: #ffe5e9;
    }

    .operational-status.unknown {
        color: #a36a00;
        background: #fff2d7;
    }

    /* ===== DAFTAR INFORMASI ===== */
    .info-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .info-list li {
        padding: 9px 0;
        border-bottom: 1px solid #edf1f7;
        line-height: 1.7;
    }

    .info-list li:first-child {
        padding-top: 0;
    }

    .info-list li:last-child {
        padding-bottom: 0;
        border-bottom: 0;
    }

    .info-list strong {
        color: #14213d;
        font-weight: 700;
    }

    /* ===== PENGUMUMAN ===== */
    .announcement-item {
        padding: 11px 0;
        border-bottom: 1px solid #edf1f7;
    }

    .announcement-item:first-child {
        padding-top: 0;
    }

    .announcement-item:last-child {
        padding-bottom: 0;
        border-bottom: 0;
    }

    .announcement-item h4 {
        margin-bottom: 4px;
        color: #14213d;
        font-size: 12px;
        font-weight: 800;
        line-height: 1.6;
        overflow-wrap: anywhere;
    }

    .announcement-date {
        margin-bottom: 5px;
        color: #8491a8;
        font-size: 10px;
    }

    .info-empty {
        padding: 16px 8px;
        color: #7182a3;
        font-size: 12px;
        line-height: 1.8;
        text-align: center;
    }

    /* ===== BAGIAN BAWAH KARTU ===== */
    .info-footer {
        padding: 10px 16px;
        margin-top: auto;
        border-top: 1px solid #edf1f7;
        color: #7184a8;
        font-size: 10px;
        line-height: 1.7;
        overflow-wrap: anywhere;
    }

    .info-footer strong {
        color: #3264d8;
    }

    .info-footer a {
        display: inline-block;
        text-decoration: none;
    }

    .info-footer a:hover strong {
        text-decoration: underline;
    }

    /* ===== RESPONSIVE TABLET ===== */
    @media (max-width: 1050px) {
        .welcome {
            align-items: flex-start;
        }

        .date-box {
            min-width: 185px;
        }

        .stats {
            gap: 10px;
        }

        .stat-card {
            gap: 10px;
            padding: 13px;
        }

        .stat-icon {
            width: 41px;
            height: 41px;
            flex-basis: 41px;
        }

        .stat-number {
            font-size: 25px;
        }

        .workshop-photo {
            height: 195px;
        }
    }

    /* ===== RESPONSIVE HP ===== */
    @media (max-width: 700px) {
        .dashboard-content {
            padding-bottom: 16px;
        }

        .welcome {
            flex-direction: column;
            align-items: stretch;
            gap: 13px;
            padding: 15px;
            margin-bottom: 13px;
        }

        .welcome h1 {
            font-size: 19px;
        }

        .welcome p {
            font-size: 11px;
        }

        .welcome-hand {
            width: 41px;
            height: 41px;
            flex-basis: 41px;
        }

        .date-box {
            width: 100%;
            min-width: 0;
        }

        .stats {
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 10px;
            margin-bottom: 20px;
        }

        .stat-card {
            min-height: 100px;
            align-items: flex-start;
            gap: 9px;
            padding: 12px 10px;
        }

        .stat-icon {
            width: 35px;
            height: 35px;
            flex-basis: 35px;
            border-radius: 10px;
        }

        .stat-icon svg {
            width: 21px;
            height: 21px;
        }

        .stat-title {
            font-size: 11px;
        }

        .stat-number {
            font-size: 23px;
        }

        .stat-description {
            font-size: 9px;
        }

        .section-heading {
            margin-bottom: 11px;
        }

        .section-heading h2 {
            font-size: 17px;
        }

        .section-heading p {
            font-size: 11px;
        }

        .info-grid {
            grid-template-columns: 1fr;
            gap: 12px;
        }

        .info-card.full {
            grid-column: auto;
        }

        .info-card-header {
            padding: 12px 14px;
        }

        .info-card-body {
            padding: 12px 14px;
        }

        .workshop-photo {
            height: 210px;
        }

        .photo-caption {
            padding: 9px 14px;
        }

        .info-footer {
            padding: 10px 14px;
        }
    }

    @media (max-width: 390px) {
        .welcome h1 {
            font-size: 17px;
        }

        .welcome-left {
            align-items: flex-start;
        }

        .stats {
            gap: 8px;
        }

        .stat-card {
            flex-direction: column;
            min-height: 118px;
            padding: 11px;
        }

        .stat-number {
            font-size: 22px;
        }

        .workshop-photo {
            height: 180px;
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

        $pengumuman = $pengumuman ?? collect();
    @endphp

    {{-- SAMBUTAN PELANGGAN --}}
    <section class="welcome">
        <div class="welcome-left">
            <div class="welcome-hand" aria-hidden="true">
                <svg width="27" height="27" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="1.8">
                    <path d="M4 19V5M4 19h16"/>
                    <path d="m7 15 4-4 3 2 5-6"/>
                    <path d="M16 7h3v3"/>
                </svg>
            </div>

            <div>
                <h1>Dashboard Pelanggan</h1>
                <p>
                    Selamat datang kembali,
                    <strong>{{ $namaPelanggan }}</strong>!
                    Lihat informasi bengkel dan pantau booking servis Anda.
                </p>
            </div>
        </div>

        <div class="date-box">
            <div class="date-icon">
                <svg width="21" height="21" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2">
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

    {{-- STATISTIK BOOKING --}}
    <section class="stats">
        <div class="stat-card stat-blue">
            <div class="stat-icon">
                <svg width="25" height="25" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2">
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
                <svg width="25" height="25" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2">
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
                <svg width="25" height="25" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2">
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

    {{-- INFORMASI BENGKEL --}}
    <div class="section-heading">
        <h2>Informasi Bengkel</h2>
        <p>
            Kenali Bengkel Royal Motor, lihat jam operasional, dan baca
            informasi terbaru sebelum datang untuk servis.
        </p>
    </div>

    <div class="info-grid">

        {{-- PROFIL BENGKEL --}}
        <section class="info-card">
            <div class="info-card-header">
                <h3>{{ $namaBengkel }}</h3>
                <p>Profil dan informasi umum bengkel</p>
            </div>

            @if(!empty($informasiBengkel?->foto_1))
                <img
                    src="{{ asset($informasiBengkel->foto_1) }}"
                    alt="Foto Bengkel Royal Motor"
                    class="workshop-photo"
                    loading="lazy"
                >
            @endif

            <div class="info-card-body">
                {{ $informasiBengkel?->deskripsi
                    ?: 'Selamat datang di Bengkel Royal Motor. Kami menyediakan layanan servis dan perawatan sepeda motor untuk membantu menjaga kendaraan Anda tetap nyaman digunakan.' }}
            </div>

            @if(!empty($informasiBengkel?->deskripsi_foto_1))
                <div class="photo-caption">
                    {{ $informasiBengkel->deskripsi_foto_1 }}
                </div>
            @endif

            <div class="info-footer">
                <strong>Bengkel Royal Motor</strong><br>
                Servis Motor, Solusi Perjalananmu.
            </div>
        </section>

        {{-- JAM OPERASIONAL --}}
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
                Perhatikan jadwal operasional sebelum berkunjung ke bengkel.
            </div>
        </section>

        {{-- INFORMASI LAYANAN --}}
        <section class="info-card">
            <div class="info-card-header">
                <h3>Informasi Layanan</h3>
                <p>Informasi layanan yang tersedia</p>
            </div>

            @if(!empty($informasiBengkel?->foto_2))
                <img
                    src="{{ asset($informasiBengkel->foto_2) }}"
                    alt="Informasi layanan Bengkel Royal Motor"
                    class="workshop-photo"
                    loading="lazy"
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
                <div class="photo-caption">
                    {{ $informasiBengkel->deskripsi_foto_2 }}
                </div>
            @endif

            <div class="info-footer">
                <a href="{{ route('booking.create') }}">
                    <strong>Booking servis sekarang →</strong>
                </a>
            </div>
        </section>

        {{-- PENGUMUMAN BENGKEL --}}
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